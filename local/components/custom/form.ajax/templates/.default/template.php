<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;
?>
<div class="col-md-3">
    <form id="fa-custom-ajax-form" action="">
        <div class="row _mb10">
            <div class="col-md-12">
                <label for="fa-name"><?=Loc::getMessage("FA_LABEL_NAME")?></label>
            </div>
            <div class="col-md-12">
                <input id="fa-name" name="FA_NAME" type="text" />
            </div>
        </div>
        <div class="row _mb10">
            <div class="col-md-12">
                <label for="fa-phone"><?=Loc::getMessage("FA_LABEL_PHONE")?></label>
            </div>
            <div class="col-md-12">
                <input id="fa-phone" name="FA_PHONE" type="text" />
            </div>
        </div>
        <input type="hidden" name="SESSID" value="<?=bitrix_sessid()?>" />
        <input class="_mb10" type="submit" value="Отправить">
    </form>
</div>
