<!DOCTYPE html>
<html>
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Basic Crud</title>
        <!-- include libraries(jQuery, bootstrap, fontawesome) -->
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script> 
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 
        <script src="<?php echo base_url('assets/process/page.js') ?>"></script>
    </head> 
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Basic Crud Application</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo $this->config->item('url_dashboard'); ?>">Dashboard</a></li>
                        <li class="active"><a href="<?php echo $this->config->item('url_pages'); ?>">Pages</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo $this->config->item('url_logout'); ?>">Logout</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="<?php echo $this->config->item('url_dashboard'); ?>">Dashboard</a></li>
                <li class="active">Pages</li>
            </ol>
            <h1>Pages</h1>
            <br />
            <a href="<?php echo $this->config->item('url_page_add'); ?>">
                <button class="btn btn-success pull-right">Add New</button>
            </a>
            <br />
            <div class="success_message">
                <?php if ($this->session->flashdata('success_message')):echo $this->session->flashdata('success_message');
                endif; ?><br/>
            </div>
            <div class="error_message">
            <?php if ($this->session->flashdata('error_message')):
                echo $this->session->flashdata('error_message');
            endif; ?>
            <br/>
            </div>
            <br />
            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Page Title</th>
                        <th>Last Modified</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result): ?>
                        <tr>
                            <td><?php echo $result->id; ?></td>
                            <td><?php echo $result->title; ?></td>
                            <td><?php echo $result->last_modified; ?></td>
                            <td>
                                <a href="<?php echo $this->config->item('url_page_edit') . $result->id; ?>">
                                    <button class="btn btn-primary" >Edit</button>
                                </a>
                                <button class="btn btn-danger" onclick="return confirm_delete_page(<?php echo $result->id; ?>)" >Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>