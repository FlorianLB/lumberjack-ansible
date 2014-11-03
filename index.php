<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Lumberjack - Ansible</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css" media="all">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" media="all">
  <!-- <link rel="stylesheet" type="text/css" href="assets/css/cosmo.bootstrap.min.css"> -->
  <link rel="stylesheet" href="assets/css/styles.css" media="all">
  <link href="assets/css/select2.css" rel="stylesheet"/>

  <script type="text/javascript" src="assets/js/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.select2-tags').select2({tags: []});
    });
  </script>
</head>
<body>
  <div class="container">

    <div class="page-header">
      <img id="logo" class="pull-left" src="assets/img/lumberjack-pattern.jpg" width="100" />
      <h1>Lumberjack</h1>
      <p class="lead">A custom virtual machine designed for PHP developpement with Vagrant that you can customize</small>.</p>
    </div>

    <form action="generator.php" method="POST">

      <div class="bs-callout bs-callout-info">
        <h4>An opinionated package</h4>
        <p>This generator is designed to bring a <strong>Debian Wheezy 7.0</strong> virtual machine provided by VirtualBox by default and provisioned with <strong>Ansible</strong>. The couple <strong>PHP-FPM + Nginx</strong> is always included.</p>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h2>
            <span class="glyphicon glyphicon-cog"></span>
            Virtual machine parameters
          </h2>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="form-group col-md-6">
              <label for="addressip">Local VM IP address</label>
              <input type="text" class="form-control" id="addressip" name="general[address_ip]" value="192.168.10.10">
              <p class="help-block">You <em>should</em> use an IP from the <a href="//en.wikipedia.org/wiki/Private_network#Private_IPv4_address_spaces">reserved private address space</a>.</p>
            </div>
            <div class="form-group col-md-6">
              <label for="hostname">Host name of your application</label>
              <input type="text" class="form-control" id="hostname" name="general[hostname]" value="foobar.dev">
              <p class="help-block">You will have to add this host into your /etc/hosts file.</p>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-6">
              <label for="vm_name">Local VM name</label>
              <input type="text" class="form-control" id="vm_name" name="general[vm_name]" value="foobar-dev">
            </div>
            <div class="form-group col-md-6">
              <label for="project_name">Project name</label>
              <input type="text" class="form-control" id="project_name" name="general[project_name]" value="My project">
            </div>
          </div>
        </div>
      </div>

      <div class="clearfix panel panel-default">
        <div class="panel-heading">
          <h2><img src="assets/img/php-logo.png" alt="PHP" height="40" /></span></h2>
        </div>

        <div class="panel-body">
            <input name="php5[enabled]" type="hidden" checked readonly value="on"/>

            <div class="form-inline">
              <div class="form-group">
                <label>PHP Version</label>
                <div>
                  <label class="radio-inline">
                    <input type="radio" name="php5[version]" value="54" checked> 5.4
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="php5[version]" value="55" disabled> 5.5
                    <span class="glyphicon glyphicon-exclamation-sign text-danger" data-toggle="tooltip" data-placement="right" title="Not supported yet"></span>
                  </label>
                </div>
              </div>

              <div class="form-group">
                <label>Composer</label>
                <div>
                  <label class="checkbox-inline">
                    <input name="php5[composer]" type="checkbox" checked/> Install Composer
                  </label>
                </div>
              </div>
            </div>
          </div>
      </div>

      <div class="clearfix panel panel-default">
        <div class="panel-heading">
          <h2><img src="assets/img/druplicon.png" alt="PHP" height="40" /></span></h2>
        </div>

        <div class="panel-body">
            <input name="drush[enabled]" type="hidden" checked readonly value="on"/>
              <div class="form-group">
                <label>Drush</label>
                <div>
                  <label class="checkbox-inline">
                    <input name="drush" type="checkbox" checked/> Install Drush
                  </label>
                </div>
              </div>
            <div class="form-inline">
              <div class="form-group">
                <label>Drush Version</label>
                <div>
                  <label class="radio-inline">
                    <input type="radio" name="drush[version]" value="6" checked> 6.*
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="drush[version]" value="7" disabled> 7.*
                    <span class="glyphicon glyphicon-exclamation-sign text-danger" data-toggle="tooltip" data-placement="right" title="Not supported yet"></span>
                  </label>
                </div>
              </div>

            </div>
          </div>
      </div>

      <div class="clearfix panel panel-default">
        <div class="panel-heading">
          <h2><span class="glyphicon glyphicon-tower"></span> System</h2>
        </div>

        <div class="panel-body">
          <div class="form-group">
            <label for="system-package">System packages</label>
            <input multiple name="system-packages" class="select2-tags form-control" id="system-package" value="curl,git,vim,htop,ncdu,wget"/>
          </div>
        </div>
      </div>

      <?php
        $config = json_decode(file_get_contents(__DIR__.'/options.json'));

        $options = array();
        foreach ($config->components as $component) {
          $options[$component->category][] = $component;
        }
        $i = 0;
        foreach ($config->categories as $categorieKey => $categorie) :
      ?>
        <?php if ($i % 2 === 0) : ?>
        <div class="row">
        <?php endif; ?>

        <div class="col-md-6">
        <div class="clearfix panel panel-default">
          <div class="panel-heading">
            <h2><span class="glyphicon glyphicon-<?php echo $categorie->glyphicon; ?>"></span> <?php echo $categorie->name; ?></h2>
          </div>
          <div class="panel-body">
          <?php
            foreach ($options[$categorieKey] as $component) :
          ?>
            <div class="package">
              <h3><img src="<?php echo $component->icon; ?>" alt="<?php echo $component->name; ?>" height="<?php echo $component->icon_height; ?>" /></h3>

              <div class="checkbox">
                <label>
                  <?php if (isset($component->supported) && false === $component->supported) : ?>
                    <input name="<?php echo $component->input_name; ?>[enabled]" type="checkbox" disabled/>
                    Install <?php echo $component->name; ?>
                    <span class="glyphicon glyphicon-exclamation-sign text-danger" data-toggle="tooltip" data-placement="right" title="Not supported yet"></span>
                  <?php else : ?>
                    <input name="<?php echo $component->input_name; ?>[enabled]" type="checkbox" />
                    Install <?php echo $component->name; ?>
                  <?php endif; ?>
                </label>
              </div>
            </div>
          <?php
            endforeach;
          ?>
          </div>
        </div>
        </div>

        <?php if ($i % 2 === 1) : ?>
        </div>
        <?php endif; ?>
      <?php
        $i++;
        endforeach;
      ?>

      <p>
        <button type="submit" class="btn btn-primary btn-lg">
          <span class="glyphicon glyphicon-cloud-download"></span>

          Generate your Vagrant/Ansible configuration
        </button>
      </p>

    </form>

  </div>
</body>
</html>
