 <?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        500 Error Page
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">

      <div class="error-page">
        <h2 class="headline text-red">500</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-red"></i> Oops!</h3>

          <p>
            We will work on fixing that right away.
            Meanwhile, you may <a href="../../index.html">return to dashboard</a> or try using the search form.
          </p>

          <form class="search-form">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Search">

              <div class="input-group-btn">
                <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i>
                </button>
              </div>
            </div>
            <!-- /.input-group -->
          </form>
    
        </div>
        
        
      </div>
      <p></p>
      <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
      <!-- /.error-page -->

    </section>
    <!-- /.content -->
  </div>