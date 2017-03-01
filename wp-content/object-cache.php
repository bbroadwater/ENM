<?php
// prevent warnings in test mode
if (!defined('ABSPATH'))
    define('ABSPATH', __DIR__);

foreach(['/user/redis-config.php', ABSPATH.'/../user/redis-config.php'] as $path)
{
	if (file_exists($path))
	{
		include $path;
		break;
	}
}
if (!defined('WP_REDIS_SERVER'))
	define('WP_REDIS_SERVER', '127.0.0.1');

if (!defined('WP_REDIS_PORT'))
	define('WP_REDIS_PORT', '6380');

if (!defined('WP_REDIS_DB'))
	define('WP_REDIS_DB', false);

if (!defined('WP_REDIS_TRACK_KEYS'))
	define('WP_REDIS_TRACK_KEYS', false);

if (!defined('WP_REDIS_AUTH'))
	define('WP_REDIS_AUTH', false);

if (!defined('WP_REDIS_PERSISTENT'))
    define('WP_REDIS_PERSISTENT', true);
    
if (!defined('WP_REDIS_TIMEOUT'))
    define('WP_REDIS_TIMEOUT', 1);

/**
 * Adds a value to cache.
 *
 * If the specified key already exists, the value is not stored and the function
 * returns false.
 *
 * @param string $key        The key under which to store the value.
 * @param mixed  $value      The value to store.
 * @param string $group      The group value appended to the $key.
 * @param int    $expiration The expiration time, defaults to 0.
 *
 * @return bool                 Returns TRUE on success or FALSE on failure.
 */
function wp_cache_add($key, $value, $group = '', $expiration = 0)
{
    global $wp_object_cache;

    return $wp_object_cache->add($key, $value, $group, $expiration);
}

/**
 * Remove the item from the cache.
 *
 * Remove an item from memcached with identified by $key after $time seconds. The
 * $time parameter allows an object to be queued for deletion without immediately
 * deleting. Between the time that it is queued and the time it's deleted, add,
 * replace, and get will fail, but set will succeed.
 *
 * @link http://www.php.net/manual/en/memcached.delete.php
 *
 * @param string $key    The key under which to store the value.
 * @param string $group  The group value appended to the $key.
 *
 * @return bool             Returns TRUE on success or FALSE on failure.
 */
function wp_cache_delete($key, $group = '')
{
    global $wp_object_cache;

    return $wp_object_cache->delete($key, $group);
}

/**
 * Invalidate all items in the cache.
 *
 * @return bool TRUE on success or FALSE on failure.
 */
function wp_cache_flush()
{
    global $wp_object_cache;

    return $wp_object_cache->flush();
}

/**
 * Retrieve object from cache.
 *
 * Gets an object from cache based on $key and $group.
 *
 * @link http://www.php.net/manual/en/memcached.get.php
 *
 * @param string      $key        The key under which to store the value.
 * @param string      $group      The group value appended to the $key.
 *
 * @return bool|mixed               Cached object value.
 */
function wp_cache_get($key, $group = '')
{
    global $wp_object_cache;

    return $wp_object_cache->get($key, $group);
}
/**
 * Sets a value in cache.
 *
 * The value is set whether or not this key already exists in memcached.
 *
 * @link http://www.php.net/manual/en/memcached.set.php
 *
 * @param string $key        The key under which to store the value.
 * @param mixed  $value      The value to store.
 * @param string $group      The group value appended to the $key.
 * @param int    $expiration The expiration time, defaults to 0.
 *
 * @return bool                 Returns TRUE on success or FALSE on failure.
 */
function wp_cache_set($key, $value, $group = '', $expiration = 0)
{
    global $wp_object_cache;

    return $wp_object_cache->set($key, $value, $group, $expiration);
}

/**
 * Sets up Object Cache Global and assigns it.
 *
 * @global  WP_Object_Cache $wp_object_cache    WordPress Object Cache
 * @return  void
 */
function wp_cache_init()
{
    global $wp_object_cache;
    $wp_object_cache = new WP_Object_Cache();
}

/**
 * Adds a group or set of groups to the list of non-persistent groups.
 *
 * @param   string|array $groups     A group or an array of groups to add.
 *
 * @return  void
 */
function wp_cache_add_global_groups($groups)
{
    global $wp_object_cache;
    $wp_object_cache->add_global_groups($groups);
}

/**
 * Adds a group or set of groups to the list of non-Memcached groups.
 *
 * @param   string|array $groups     A group or an array of groups to add.
 *
 * @return  void
 */
function wp_cache_add_non_persistent_groups($groups)
{
    global $wp_object_cache;
    $wp_object_cache->add_non_persistent_groups($groups);
}


function wp_cache_switch_to_blog($blog_id)
{
    global $wp_object_cache;
    $wp_object_cache->switch_to_blog($blog_id);
}

function wp_cache_close()
{
    return true;
}

function wp_cache_replace( $key, $data, $group = '', $expire = 0 )
{
    global $wp_object_cache;
    return $wp_object_cache->replace( $key, $data, $group, (int) $expire );
}

function wp_cache_incr($key, $offset = 1, $group = '') 
{
    global $wp_object_cache;

    return $wp_object_cache->incr($key, $offset, $group);
}

function wp_cache_decr($key, $offset = 1, $group = '') 
{
    global $wp_object_cache;

    return $wp_object_cache->decr( $key, $offset, $group );
}


class WP_Object_Cache
{
    // unique value to store in the runtime cache for a miss
    const MISS = '_______MISSMISS_______fuicPhost%^&*';

    /**
     * Holds the Redis client.
     *
     * @var Redis
     */
    public $redis;

    /**
     * Holds the non-Redis objects.
     *
     * @var array
     */
    public $cache = array();

    /**
     * List of global groups.
     *
     * @var array
     */
    public $global_groups = array('users' => 1, 'userlogins' => 1, 'usermeta' => 1, 'site-options' => 1, 'site-lookup' => 1, 'blog-lookup' => 1, 'blog-details' => 1, 'rss' => 1);

    /**
     * List of groups not saved to Redis.
     *
     * @var array
     */
    public $non_persistent_groups = array('comment' => 1, 'counts' => 1);

    public $site_prefix = '';

    /**
     * Prefix used for non-global groups.
     *
     * @var string
     */
    public $blog_prefix = '';

    /**
     * Default expirary value
     *
     * Used whenever an expirary is set to 0
     *
     * @var int
     */
    public $default_expirary = 3600;

    /**
     * Last fetched version of alloptions
     */
    protected $last_all_options = [];

    /**
     * Maximum size of notoptions array
     */
    const MAX_NOOPTIONS = 2000;

    /**
     * Instantiate the Redis class.
     *
     * Instantiates the Redis class.
     *
     * @param   null $persistent_id      To create an instance that persists between requests, use persistent_id to specify a unique ID for the instance.
     */
    public function __construct()
    {
        // kill switch, just for this class
        if (defined('WP_REDIS_DISABLED') && WP_REDIS_DISABLED)
        {
            $this->redis = false;
            return;
        }

        $this->connect();

        /*
          site prefix aka domain prefix

          in a single site dump everything into global namespace

          on multi-site separate global and non-global groups; non-global
          groups are the per-blog/per-sub-site groups

         */

	if (!defined('WP_REDIS_SITE_PREFIX'))
	{
		$site_prefix = "";

		if (defined('NONCE_SALT')) {
		    $site_prefix .= NONCE_SALT;
		}

		if (defined('WP_CONTENT_DIR')) {
                    $content_dir = WP_CONTENT_DIR;
                    if (preg_match('@/(dom[0-9]+)@', $content_dir, $match))
                        $content_dir = $match[1];

		    $site_prefix .= $content_dir;
		}

		$this->set_site_prefix(sha1($site_prefix));
	}
	else
	{
		$this->set_site_prefix(WP_REDIS_SITE_PREFIX);
	}

        $this->add_global_groups("pagely_object_cache");
    }

    public function connect()
    {
        try {
            $this->redis = new Redis();

            if (WP_REDIS_PERSISTENT)
                $method = 'pconnect';
            else
                $method = 'connect';

            if (!$this->redis->$method(WP_REDIS_SERVER, WP_REDIS_PORT, WP_REDIS_TIMEOUT)) {
                throw new RedisException("Cannot connect to Redis server");
            }

            if (WP_REDIS_DB != false)
                $this->redis->select(WP_REDIS_DB);

            if (WP_REDIS_AUTH != false)
                $this->redis->auth(WP_REDIS_AUTH);

        } catch(RedisException $e) {
            trigger_error("Unable to connect to redis, object cache disabled: ".$e->getMessage());
            $this->redis = false;
        }
    }

    public function add_tracked_key($key)
    {
	if (!WP_REDIS_TRACK_KEYS)
		return;
        // add to the Redis set that tracks keys used by this site
        $tracked_keys_key = $this->buildKey("keys", "pagely_object_cache");
        $this->redis->sadd($tracked_keys_key, $key);
    }

    public function remove_tracked_key($key)
    {
        if (!WP_REDIS_TRACK_KEYS)
            return;
        // remove from the Redis set that tracks keys used by this site
        $tracked_keys_key = $this->buildKey("keys", "pagely_object_cache");
        $this->redis->srem($tracked_keys_key, $key);
    }

    public function flush_tracked_keys()
    {
        if (!WP_REDIS_TRACK_KEYS)
            return;

        // empty the Redis set that tracks keys used by this site
        $tracked_keys_key = $this->buildKey("keys", "pagely_object_cache");
        $this->redis->del($tracked_keys_key);
    }

    public function set_site_prefix($prefix)
    {
        $this->site_prefix = $prefix;
    }

    public function get_site_prefix()
    {
        return $this->site_prefix;
    }

    /**
     * Adds a value to cache.
     *
     * If the specified key already exists, the value is not stored and the function
     * returns false.
     *
     * @param   string $key            The key under which to store the value.
     * @param   mixed  $value          The value to store.
     * @param   string $group          The group value appended to the $key.
     * @param   int    $expiration     The expiration time, defaults to 0.
     *
     * @return  bool                        Returns TRUE on success or FALSE on failure.
     */
    public function add($key, $value, $group = 'default', $expiration = 0)
    {
        if ($key === 'alloptions') {
            return $this->set_alloptions("___$key", $value, $group);
        }

        if ($this->has_runtime_cache($key, $group)) {
            return false;
        }

        $result = $this->add_to_runtime_cache($key, $value, $group);

        if ($this->redis && $this->is_persistent_group($group)) {
            if ($this->has_redis_cache($key, $group)) {
                $result = false;
            } else {
                $result = $this->add_to_redis_cache($key, $value, $group, $expiration);
            }
        }

        return $result;
    }


    public function replace( $key, $data, $group = 'default', $expire = 0 )
    {
        if ($this->has_runtime_cache($key, $group)) {
            $result = $this->add_to_runtime_cache($key, $value, $group);
        }

        if ($this->redis && $this->is_persistent_group($group)) {
            if ($this->has_redis_cache($key, $group)) {
                $result = $this->add_to_redis_cache($key, $value, $group, $expiration);
            } else {
                $result = false;
            }
        }

        return $result;
    }

    public function has_redis_cache($key, $group)
    {
        $derived_key = $this->buildKey($key, $group);

        return $this->redis->exists($derived_key);
    }

    public function add_to_redis_cache($key, $value, $group = "", $expiration = 0)
    {
        $derived_key = $this->buildKey($key, $group);

        if ($expiration == 0) {
            $expiration = $this->default_expirary;
        }

        $this->add_tracked_key($derived_key);

        $result = $this->redis->setex($derived_key, $expiration, serialize($value));

        return $result;
    }

    public function is_persistent_group($group)
    {
        return !isset($this->non_persistent_groups[$group]);
    }

    public function is_runtime_group($group)
    {
        return isset($this->non_persistent_groups[$group]);
    }

    /**
     * Remove the item from the cache.
     *
     * Remove an item from memcached with identified by $key after $time seconds. The
     * $time parameter allows an object to be queued for deletion without immediately
     * deleting. Between the time that it is queued and the time it's deleted, add,
     * replace, and get will fail, but set will succeed.
     *
     * @link http://www.php.net/manual/en/memcached.delete.php
     *
     * @param   string $key        The key under which to store the value.
     * @param   string $group      The group value appended to the $key.
     * @param   int    $time       The amount of time the server will wait to delete the item in seconds.
     * @param   string $server_key The key identifying the server to store the value on.
     * @param   bool   $byKey      True to store in internal cache by key; false to not store by key
     *
     * @return  bool                    Returns TRUE on success or FALSE on failure.
     */
    public function delete($key, $group = 'default')
    {
        if ($key === "alloptions")
            $key = "___alloptions";

        $result = $this->delete_from_runtime_cache($key, $group);

        if ($this->redis && $this->is_persistent_group($group)) {
            $result =  $this->delete_from_redis_cache($key, $group);
        }

        if ($key === 'alloptions')
            $this->last_alloptions = [];

        return $result;
    }

    public function delete_from_runtime_cache($key, $group)
    {
        $derived_key = $this->buildKey($key, $group);

        if (isset($this->cache[$derived_key])) {
            unset($this->cache[$derived_key]);
            return true;
        }

        return false;
    }

    public function delete_from_redis_cache($key, $group)
    {
        if ($key === "alloptions")
            $key = "___alloptions";

        $derived_key = $this->buildKey($key, $group);
        $this->remove_tracked_key($derived_key);

        $result = $this->redis->del( $derived_key );

        return (bool)$result;
    }

    /**
     * Invalidate all items in the cache.
     *
     * @return  bool                Returns TRUE on success or FALSE on failure.
     */
    public function flush()
    {
        $result = $this->flush_runtime_cache();

        if ($this->redis) {
            $result = $this->flush_redis_cache();
        }

        return $result;
    }

    public function flush_runtime_cache()
    {
        $this->cache = array();

        return true;
    }

    public function flush_redis_cache()
    {

        if (!WP_REDIS_TRACK_KEYS)
        {
            $this->redis->flushDb();
            return;
        }
        $tracked_keys_key = $this->buildKey("keys", "pagely_object_cache");
        $this->redis->del($this->redis->smembers($tracked_keys_key));
        $this->flush_tracked_keys();
    }

    /**
     * Retrieve object from cache.
     *
     * Gets an object from cache based on $key and $group.
     *
     * @param   string        $key        The key under which to store the value.
     * @param   string        $group      The group value appended to the $key.
     * @param   string        $server_key The key identifying the server to store the value on.
     * @param   bool          $byKey      True to store in internal cache by key; false to not store by key
     *
     * @return  bool|mixed                  Cached object value.
     */
    public function get($key, $group = 'default')
    {
        if ($key === 'alloptions') {
            return $this->get_alloptions("___$key", $group);
        }

        $result = $this->get_from_runtime_cache($key, $group);

        if ($result === self::MISS) {
            return false;
        }
        else if ($result === false && $this->redis && $this->is_persistent_group($group)) {
            $result = $this->get_from_redis_cache($key, $group);

            if ($result) {
                $result = unserialize($result);
                $this->add_to_runtime_cache($key, $result, $group);
            }
            else {
                $this->add_to_runtime_cache($key, self::MISS, $group);
            }
        }

        return $result;
    }

    public function incr($key, $offset = 1, $group = 'default') 
    {
        $result =  $this->get_from_runtime_cache($key, $group);

        if (!$result && $this->redis && $this->is_persistent_group($group)) {
            $result = $this->get_from_redis_cache($key, $group);
        }

        if ($result === false) {
            return false;
        }
        
        if (!is_numeric($result)) {
            $result = 0;
        }
        
        $result += (int)$offset;
        
        if ($result < 0) {
            $result = 0;
        }

        $this->set($key, $result, $group);

        return $result;
    }

    public function decr($key, $offset = 1, $group = 'default') 
    {
        $result =  $this->get_from_runtime_cache($key, $group);

        if (!$result && $this->redis && $this->is_persistent_group($group)) {
            $result = $this->get_from_redis_cache($key, $group);
        }

        if (!$result) {
            return false;
        }
        
        if (!is_numeric($result)) {
            $result = 0;
        }
        
        $result -= (int)$offset;
        
        if ($result < 0) {
            $result = 0;
        }

        $this->set($key, $result, $group);

        return $result;
    }


    public function get_from_redis_cache($key, $group)
    {
        $derived_key = $this->buildKey($key, $group);

        return $this->redis->get($derived_key);
    }

    /**
     * Sets a value in cache.
     *
     * The value is set whether or not this key already exists in memcached.
     *
     * @link http://www.php.net/manual/en/memcached.set.php
     *
     * @param   string $key        The key under which to store the value.
     * @param   mixed  $value      The value to store.
     * @param   string $group      The group value appended to the $key.
     * @param   int    $expiration The expiration time, defaults to 0.
     * @param   string $server_key The key identifying the server to store the value on.
     * @param   bool   $byKey      True to store in internal cache by key; false to not store by key
     *
     * @return  bool                    Returns TRUE on success or FALSE on failure.
     */
    public function set($key, $value, $group = 'default', $expiration = 0)
    {
        if ($key === 'alloptions') {
            return $this->set_alloptions("___$key", $value, $group);
        }

        // cap the max size of notopations at 2k elements, by shifting we should be removing the oldest items first
        if ($key === 'notoptions' && count($value) > self::MAX_NOOPTIONS) {
            $t = microtime(true);
            while(count($value) > self::MAX_NOOPTIONS)
                array_shift($value);
        }

        $result = $this->add_to_runtime_cache($key, $value, $group);

        if ($this->redis && $this->is_persistent_group($group)) {
            $result = $this->add_to_redis_cache($key, $value, $group, $expiration);
        }

        return $result;
    }

    /**
     * Turns alloptions set into a hset of just the changes from the last fetch
     * This works because the update patterns for alloptions is fetch array, update array, 
     * set array
     *
     * There are races, amoung multiple processes, but not in a single one.
     */
    protected function set_alloptions($key, $value, $group)
    {
        $new_value = $this->last_all_options;
        $derived_key = $this->buildKey($key, $group);

        // alloptions is empty
        if (count($this->last_all_options) == 0) {
            $new_value = $value;
            $hash = array_map('serialize', $value);
            if ($this->redis)
                $this->redis->hmset($derived_key, $hash);
        } else {
            foreach($value as $k => $v) {
                if (!isset($this->last_all_options[$k]) || $this->last_all_options[$k] != $v) {
                    $new_value[$k] = $v;
                    if ($this->redis)
                        $this->redis->hset($derived_key, $k, serialize($v));
                }
            }

            foreach ($this->last_all_options as $k => $v) {
                if (!isset($value[$k])) {
                    unset($new_value[$k]);
                    if ($this->redis)
                        $this->redis->hdel($derived_key, $k);
                }
            }
        }
        $result = $this->add_to_runtime_cache($key, $new_value, $group);

        return $result;
    }

    /**
     * Since alloption is a hash it needs a special reading function
     */
    protected function get_alloptions($key, $group)
    {
        $derived_key = $this->buildKey($key, $group);

        $all =  $this->get_from_runtime_cache($key, $group);
        if ($this->redis && !$all) {
            $all = $this->redis->hgetall($derived_key);
            $all = array_map('unserialize', $all);
            if (count($all) == 0)
              $all = false;
            $this->add_to_runtime_cache($key, $all, $group);
        }
        if ($all === false)
            $this->last_all_options = [];
        else
            $this->last_all_options = $all;

        return $all;
    }

    /**
     * Builds a key for the cached object using the blog_id, key, and group values.
     *
     * @author  Ryan Boren   This function is inspired by the original WP Memcached Object cache.
     * @link    http://wordpress.org/extend/plugins/memcached/
     *
     * @param   string $key        The key under which to store the value.
     * @param   string $group      The group value appended to the $key.
     *
     * @return  string
     */
    public function buildKey($key, $group = 'default')
    {
        if (empty($group)) {
            $group = 'default';
        }

        $parts[] = $this->site_prefix;

        if (is_multisite() && !isset($this->global_groups[$group])) {
            $parts[] = $this->blog_prefix;
        }

        $parts[] = $group;
        $parts[] = $key;

        $key = implode($parts, ":");
        return $key;
    }

    /**
     * Simple wrapper for saving object to the internal cache.
     *
     * @param   string $derived_key    Key to save value under.
     * @param   mixed  $value          Object value.
     */
    public function add_to_runtime_cache($key, $value, $group = "")
    {
        $derived_key = $this->buildKey( $key, $group );

        if (is_object($value)) {
            $value = clone $value;
        }

        $this->cache[$derived_key] = $value;
        return true;
    }

    public function switch_to_blog($blog_id)
    {
		$this->blog_prefix = is_multisite() ? $blog_id . ':' : '';
    }

    /**
     * Get a value specifically from the internal, run-time cache, not Redis.
     *
     * @param   int|string $key        Key value.
     * @param   int|string $group      Group that the value belongs to.
     *
     * @return  bool|mixed              Value on success; false on failure.
     */
    public function get_from_runtime_cache($key, $group)
    {
        $derived_key = $this->buildKey( $key, $group );

        if (isset( $this->cache[$derived_key])) {
            return $this->cache[$derived_key];
        }

        return false;
    }

    public function has_runtime_cache($key, $group)
    {
        $derived_key = $this->buildKey($key, $group);

        if(isset($this->cache[$derived_key]) && $this->cache[$derived_key] !== self::MISS)
            return true;
        else
            return false;
    }

    /**
     * Sets the list of global groups.
     *
     * @param array $groups List of groups that are global.
     */
    function add_global_groups($groups)
    {
        $groups = (array) $groups;

        foreach($groups as $group)
            $this->global_groups[$group] = 1;
    }

    /**
     * Sets the list of groups not to be cached by Redis.
     *
     * @param array $groups List of groups that are to be ignored.
     */
    function add_non_persistent_groups($groups)
    {
        $groups = (array) $groups;

        foreach($groups as $group)
            $this->non_persistent_groups[$group] = 1;
    }
}
