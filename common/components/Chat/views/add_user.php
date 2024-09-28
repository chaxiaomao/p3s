<div id="add-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only"><?=Yii::t('app.c2', 'Close'); ?></span>
                </button>
                <h4 class="modal-title"><?=Yii::t('app.c2', 'Add User'); ?></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="username"><?=Yii::t('app.c2', 'Username'); ?>:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=Yii::t('app.c2', 'Close'); ?>
                </button>
                <button type="button" id="add-user-btn" class="btn btn-primary"><?=Yii::t('app.c2', 'Add'); ?></button>
            </div>
        </div>
    </div>
</div>