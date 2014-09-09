<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Dashboard VW CRM project</title>
    <style type="text/css">
        body {
            background: #F2F4F8;
            color: #272E3D;
        }
        h1, h2 {text-align: center;}

        .available, .no-available {
            width: 50px;
            height: 50px;
            display: inline-block;
            border-radius: 50px;
            background: #79C447;
            line-height: 50px;
            text-align: center;
            color: white;
            font-size: 20px;
            margin: 5px;
        }
        .no-available {background: #FF5454;}

        table {border-collapse: collapse; border-spacing: 0px; margin: 0 auto;}

        td, th {
            border: 1px solid #E1E6EF;
            padding: 8px;
            text-align: center;
            background: #fff;
        }
        th a {color: #374767; text-decoration: none;}
        th a:hover {text-decoration: underline;}
    </style>
</head>
<body>
    <h1><?php echo $general['project_name']; ?></h1>

    [?php
        require_once 'functions.php';
    ?]

    <h2>Status</h2>

    <table>
        <thead>
            <tr>
                <th><a href="http://{{ host_name }}:{{ nginx_port_dashboard }}/apc.php">APC</a></th>

                <?php if (isset($rolesToInstall['memcached'])) : ?>
                    <th><a href="http://{{ host_name }}:{{ nginx_port_memcadmin }}">Memcached</a></th>
                <?php endif; ?>

                <?php if (isset($rolesToInstall['elasticsearch'])) : ?>
                    <th><a href="http://{{ host_name }}:9200/_plugin/head">ElasticSearch</a></th>
                <?php endif; ?>

                <?php if (isset($rolesToInstall['mongodb'])) : ?>
                    <th><a href="http://{{ host_name }}:{{ nginx_port_rockmongo }}">MongoDB</a></th>
                <?php endif; ?>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    [?php printStatus(apcIsEnabled()); ?]
                </td>

                <?php if (isset($rolesToInstall['memcached'])) : ?>
                    <td>
                        [?php printStatus(memcacheIsEnabled()); ?]
                    </td>
                <?php endif; ?>

                <?php if (isset($rolesToInstall['elasticsearch'])) : ?>
                    <td>
                        [?php printStatus(elasticsearchIsEnabled()); ?]
                    </td>
                <?php endif; ?>

                <?php if (isset($rolesToInstall['mongodb'])) : ?>
                    <td>
                        [?php printStatus(mongodbIsEnabled()); ?]
                    </td>
                <?php endif; ?>
            </tr>
        </tbody>
    </table>

    <h2>Tools</h2>

    <table>
        <thead>
            <tr>
                <?php if (isset($rolesToInstall['mailcatcher'])) : ?>
                    <th><a href="http://{{ host_name }}:1080">MailCatcher</a></th>
                <?php endif; ?>

                <?php if (isset($rolesToInstall['pimpmylog'])) : ?>
                    <th><a href="http://{{ host_name }}:{{ nginx_port_pimpmylog }}">PimpMyLog</a></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php if (isset($rolesToInstall['mailcatcher'])) : ?>
                    <td>
                        <img src="http://{{ host_name }}:1080/images/logo.png" alt="MailCatcher" />
                    </td>
                <?php endif; ?>

                <?php if (isset($rolesToInstall['pimpmylog'])) : ?>
                    <td>
                        <img src="http://{{ host_name }}:{{ nginx_port_pimpmylog }}/img/icon36.png" alt="PimpMyLog" />
                    </td>
                <?php endif; ?>
            </tr>
        </tbody>
    </table>

</body>
</html>