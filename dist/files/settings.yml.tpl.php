---

user: "vagrant"

host_name: "<?php echo $general['hostname']; ?>"
log_dir: "/home/vagrant/logs"
framework: <?php if (!empty($framework)) : ?>
 "<?php echo $framework; ?>"
<?php endif; ?>

# Nginx
nginx_port_dashboard: "1000"

<?php if (isset($rolesToInstall['pimpmylog'])) : ?>
nginx_port_pimpmylog: "1090"
<?php endif; ?>
<?php if (isset($rolesToInstall['memcached'])) : ?>
nginx_port_memcadmin: "1091"
<?php endif; ?>
<?php if (isset($rolesToInstall['mongodb'])) : ?>
nginx_port_rockmongo: "1092"
<?php endif; ?>

<?php if (isset($rolesToInstall['memcached'])) : ?>
# Memcached
memcached_memory: "128" # Memory size in MB
<?php endif; ?>


<?php if (isset($rolesToInstall['elasticsearch'])) : ?>
# ElasticSearch
elasticsearch_timezone: "Europe/Paris"
elasticsearch_plugins:
  - { name: 'mobz/elasticsearch-head' }
  - { name: 'royrusso/elasticsearch-HQ' }
<?php endif; ?>

<?php if (isset($rolesToInstall['mariadb'])) : ?>
mariadb_version: 10.1
mariadb_repo_url: http://nwps.ws/pub/mariadb/repo/{{ mariadb_version }}/debian
<?php endif; ?>

<?php if (isset($rolesToInstall['mariadb']) || isset($rolesToInstall['mysql'])) : ?>
mysql_db_user: vagrant
mysql_db_password: vagrant
<?php endif; ?>

<?php if (isset($rolesToInstall['redis'])) : ?>
# Redis (look at dist/roles-available/redis/defaults/mail.yml for all options)
# Conf based on https://github.com/DavidWittman/ansible-redis
redis_bind: 127.0.0.1
redis_port: 6379
<?php endif; ?>

system_packages:
<?php foreach ($systemPackages as $packageName) : ?>
  - <?php echo $packageName . PHP_EOL; ?>
<?php endforeach; ?>
