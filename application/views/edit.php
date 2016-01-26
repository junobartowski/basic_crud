<!DOCTYPE html>
<html>
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Basic Crud</title>
        <link href="<?php echo base_url('assets/styles/main.css') ?>" rel="stylesheet">

        <!-- include libraries(jQuery, bootstrap, fontawesome) -->
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script> 
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 

        <!-- include summernote css/js-->
        <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.7.3/summernote.css" rel="stylesheet">
        <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.7.3/summernote.js"></script>
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
                        <li class="active"><a href="<?php echo $this->config->item('url_page'); ?>">Pages</a></li>
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
                <li><a href="<?php echo $this->config->item('url_page'); ?>">Pages</a></li>
                <li class="active">Page edit: "<?php echo $result[0]->name; ?>"</li>
            </ol>
            <h1>Page edit: "<?php echo $result[0]->name; ?>"</h1>
            <div class="success_message">
                <?php if ($this->session->flashdata('success_message')):echo $this->session->flashdata('success_message');
                endif; ?><br/>
            </div>
            <div class="error_message">
            <?php if ($this->session->flashdata('error_message')):echo $this->session->flashdata('error_message');
            endif; ?><br/>
            </div>
            <?php echo validation_errors(); ?>
<?php $attributes = array('id' => 'edit_form'); ?>
<?php echo form_open_multipart('dashboard/page/edit/' . $result[0]->id, $attributes); ?>
            <h5>URL</h5>
            <input type="text" name="txt_url" class="form-control" value="<?= set_value('txt_url', $result[0]->url, true) ?>" size="50" />
            <h5>Name</h5>
            <input type="text" name="txt_name" class="form-control" value="<?= set_value('txt_name', $result[0]->name, true) ?>" size="50" />
            <h5>Title</h5>
            <input type="text" name="txt_title" class="form-control" value="<?= set_value('txt_title', $result[0]->title, true) ?>" size="50" />
            <h5>Content</h5>
            <textarea class="form-control" id="summernote" name="txt_area_content"><?= set_value('txt_area_content', $result[0]->content, true) ?></textarea>
            <br />
            <h4>Picture</h4>
            <h5>*Leave blank if you do not wish to upload/replace</h5>
            <input type="file" name="uploaded_photo" id="uploaded_photo" class="form-control" value="<?= set_value('txt_content') ?>" size="50" accept="image/jpeg" />
            <img id="upload_preview" src="<?php echo base_url($this->config->item('upload_path_banner')) . '/' . $result[0]->id . '.jpg'; ?>" />
            <br />
            <br />
            <div>
                <input type="button" value="Save" class="btn btn-success" onclick="return submit_edit_form();" />
                <a href="<?php echo $this->config->item('url_page'); ?>">
                    <input class="btn btn-default" type="button" value="Cancel" />
                </a>
            </div>
        </form>
    </div>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        $('#summernote').summernote({
            height: 200
        });
    });
</script>