---

user: "vagrant"

host_name: "<?php echo $general['hostname']; ?>"
log_dir: "/home/vagrant/logs"

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

system_packages:
<?php foreach ($systemPackages as $packageName) : ?>
  - <?php echo $packageName . PHP_EOL; ?>
<?php endforeach; ?>
