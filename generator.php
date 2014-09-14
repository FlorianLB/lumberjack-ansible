<?php

require __DIR__ . '/vendor/autoload.php';
use Symfony\Component\Filesystem\Filesystem;

$components = $_POST;

$general = $_POST['general'];

$rolesToInstall = array('common' => true, 'php5' => true, 'nginx' => true, 'dashboard' => true);

foreach ($components as $componentName => $value) {
    if (empty($value['enabled'])) {
        continue;
    }

    if (!isset($rolesToInstall[$componentName])) {
        $rolesToInstall[$componentName] = true;
    }
}

if (!empty($components['php5']['composer'])) {
    $rolesToInstall['composer'] = true;
}

if (!empty($components['redis']) && !empty($components['redis-packages'])) {
  foreach ($components['redis-packages'] as $key => $value) {
    $rolesToInstall[$value] = true;
  }
}

if (!empty($components['mongodb'])) {
    $rolesToInstall['rockmongo'] = true;
}

if (!empty($components['memcached'])) {
    $rolesToInstall['memcadmin'] = true;
}

$systemPackages = !empty($components['system-packages']) ? explode(',', $components['system-packages']) : array();
$systemPackages = array_unique(array_merge($systemPackages, array('curl', 'wget')));

// ---------- Roles ----------

$filesystem = new Filesystem();
$hash = substr(sha1(uniqid() * rand()), 0, 10);
$buildDir = sys_get_temp_dir() . '/lumberjack-' . $hash;

$filesystem->mkdir($buildDir);
$filesystem->mkdir($buildDir . '/ansible');

foreach (array_keys($rolesToInstall) as $role) {
    $filesystem->mirror(__DIR__ . '/dist/roles-available/' . $role, $buildDir . '/ansible/roles/' . $role);
}

// ---------- Templating ----------

foreach (['app.yml.tpl.php', 'dev.tpl.php', 'settings.yml.tpl.php'] as $file) {
    ob_start();
    require __DIR__ . '/dist/files/' . $file;
    file_put_contents($buildDir . '/ansible/' . str_replace('.tpl.php', '', $file), ob_get_clean());
}

ob_start();
require __DIR__ . '/dist/files/Vagrantfile.tpl.php';
file_put_contents($buildDir . '/Vagrantfile', ob_get_clean());

ob_start();
require __DIR__ . '/dist/files/dashboard.tpl.php';
$dashboardContent = str_replace('[?php', '<?php', str_replace('?]', '?>', ob_get_clean()));
file_put_contents($buildDir . '/ansible/roles/dashboard/templates/index.php.j2', $dashboardContent);

// To improve (concurency)
$archive = __DIR__ . '/lumberjack-ansible_' . $hash . '.tar';
$compressedArchive = $archive . '.gz';

$phar = new PharData($archive);
$phar->buildFromDirectory($buildDir);
$phar->compress(Phar::GZ);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($compressedArchive));
header('Content-Length: ' . filesize($compressedArchive));
readfile($compressedArchive);
$filesystem->remove($archive);
$filesystem->remove($compressedArchive);
$filesystem->remove($buildDir);
exit;