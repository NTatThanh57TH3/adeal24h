{include file = 'header.tpl'}
<div class="content-detail">
    <div class="detail-left">
        <h1 class="detail_title uppercase">Liên hệ với chúng tôi</h1>
        <div class="detail-content">
            {include file = '../../commons/form_contact_info/form_contact_bds.tpl'}
        </div>
    </div>
    <!--Right-->
    <div class="detail-right">
        <div class="right_box nav">
            {include file = 'modules/bds/search.tpl'}
        </div>
        {include file = 'components/contents/content_hot.tpl'}
        {include file = 'components/categories/categories_style.tpl'}
        {include file = 'components/banners/banner.tpl' position = "right"}
    </div>
</div>
{include file = 'footer.tpl'}