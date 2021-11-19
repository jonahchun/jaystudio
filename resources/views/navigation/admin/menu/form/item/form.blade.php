@php
$item = !empty($item) ? $item : new \WFN\Navigation\Model\Menu\Item();
@endphp
<div id="{{ $id }}_item_form" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-star"></i> Edit Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    @includeIf('admin::widget.form.field.text', ['name' => 'item[' . $id . '][title]', 'value' => $item->title, 'id' => $id . '_title', 'required' => true])
                </div>
                <div class="form-group">
                    <label>Link</label>
                    @includeIf('admin::widget.form.field.text', ['name' => 'item[' . $id . '][link]', 'value' => $item->link, 'id' => $id . '_link', 'required' => true])
                </div>
                <div class="form-group">
                    <label>Link Target</label>
                    @includeIf('admin::widget.form.field.select', ['name' => 'item[' . $id . '][link_target]', 'value' => $item->link_target, 'source' => new \WFN\Navigation\Model\Source\LinkTarget(), 'id' => $id . '_link_target', 'required' => true])
                </div>
                <div class="form-group">
                    <label>ID</label>
                    @includeIf('admin::widget.form.field.text', ['name' => 'item[' . $id . '][identifier]', 'value' => $item->identifier, 'id' => $id . '_identifier'])
                </div>
                <div class="form-group">
                    <label>CSS Class</label>
                    @includeIf('admin::widget.form.field.text', ['name' => 'item[' . $id . '][css_class]', 'value' => $item->css_class, 'id' => $id . '_css_class'])
                </div>
                <div class="form-group">
                    <label>CMS Block</label>
                    @includeIf('admin::widget.form.field.select', ['name' => 'item[' . $id . '][cms_block]', 'value' => $item->cms_block, 'source' => new \WFN\CMS\Model\Source\Blocks(), 'id' => $id . '_cms_block'])
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button type="button" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Save</button>
            </div>
        </div>
    </div>
</div>