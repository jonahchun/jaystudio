@extends('admin::layouts.app')

@section('content')
<div class="container-fluid form">
    <div class="row pt-2 pb-2">
        <div class="col-sm-12">
            <div class="btn-group float-sm-right">
                @includeIf('admin::widget.button', ['label' => 'Back', 'type' => 'back', 'action' => route('admin.navigation.menu')])
                @if($menu->id)
                    @includeIf('admin::widget.button', ['label' => 'Delete', 'type' => 'delete', 'action' => route('admin.navigation.menu.delete', ['id' => $menu->id]), 'class' => 'danger', 'confirmation' => true])
                @endif
                @includeIf('admin::widget.button', ['label' => 'Save', 'jsaction' => '$("#edit-form").submit()', 'type' => 'save', 'class' => 'success'])
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-uppercase">{{ $menu->id ? 'Edit menu "' . $menu->title . '"' : 'New Menu' }}</div>
                <div class="card-body">
                    <form id="edit-form" action="{{ route('admin.navigation.menu.save') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        <div id="form-vertical">
                            {{ csrf_field() }}
                            @includeIf('admin::widget.form.field.hidden', ['name' => 'id', 'value' => $menu->id])
                            <h3>General</h3>
                            <section>
                                <div class="form-group">
                                    <label>Title <em class="text-danger">*</em></label>
                                    @includeIf('admin::widget.form.field.text', ['name' => 'title', 'value' => $menu->title, 'required' => true])
                                </div>
                                <div class="form-group">
                                    <label>Identifier <em class="text-danger">*</em></label>
                                    @includeIf('admin::widget.form.field.text', ['name' => 'identifier', 'value' => $menu->identifier, 'required' => true])
                                </div>
                                <div class="form-group">
                                    <label>Status <em class="text-danger">*</em></label>
                                    @includeIf('admin::widget.form.field.select', ['name' => 'status', 'source' => new \WFN\CMS\Model\Source\Status(),'value' => $menu->status, 'required' => true])
                                </div>
                            </section>
                            @if($menu->id)
                            <h3>Items</h3>
                            <section>
                                <div class="btn-group float-sm-right">
                                    <button type="button" class="btn btn-primary waves-effect waves-light" id="add-new-menu-item">
                                        <i class="fa fa-plus-circle"></i>
                                        <span>Add New</span>
                                    </button>
                                </div>
                                <div class="dd" id="menu-items">
                                    <ol class="dd-list">
                                    @foreach($menu->items as $item)
                                        @includeIf('navigation::admin.menu.form.item', ['item' => $item])
                                    @endforeach
                                  </ol>
                            </section>
                            @endif
                        </div>
                        <input type="hidden" name="items" value="" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@includeIf('admin::widget.confirmation')

@php
    $item = false;
@endphp
<script id="menu-item-template" type="template">
    <li class="dd-item" data-id="{id}">
        <div class="btn-group" style="float: right;">
            <i class="btn btn-danger fa fa-trash-o" data-type="remove-menu-item" style="padding: 5px;"></i>
            <i class="btn btn-primary fa fa-pencil" data-type="edit-menu-item" style="padding: 5px;"></i>
        </div>
        <div class="dd-handle">{title}</div>
        @include('navigation::admin.menu.form.item.form', ['id' => '{id}'])
    </li>
</script>
<script type="text/javascript">
// <![CDATA[
jQuery(function($) {
    $("#edit-form").validate();

    var items = {
        container: $('#menu-items'),
        init: function() {
            this.container.nestable({
                group: 1
            }).on('change', this.changed.bind(this));
            $('#add-new-menu-item').click(this.addNewItem.bind(this));
            this.addRemoveListener();
            this.addEditListener();
            this.container.trigger('change');
        },
        changed: function(event) {
            $('input[name="items"]').val(JSON.stringify(this.container.nestable('serialize')));
        },
        addRemoveListener: function() {
            var self = this;
            $('[data-type="remove-menu-item"]').click(function() {
                $(this).parent().parent().remove();
                self.container.trigger('change');
            });
        },
        addEditListener: function() {
            var self = this;
            $('[data-type="edit-menu-item"]').click(function() {
                var node = $(this).parent().parent().find('.dd-handle').first();
                    id = $(this).parent().parent().data('id'),
                    modalSelector = '#' + id + '_item_form';

                $(modalSelector).modal('show');
                $(modalSelector + ' .btn-primary').click(function() {
                    if($("#edit-form").valid()) {
                        var title = $('#' + id + '_title').val();
                        node.html(title);

                        $(modalSelector).modal('hide');
                    }
                });
            });
        },
        addNewItem: function() {
            var boxes = $('#menu-item-template').html().replace('{title}', 'New Item').replaceAll('{id}', 'node-' + (this.container.find('li').length + 1));
            this.container.find('ol').first().append(boxes);
            this.addRemoveListener();
            this.addEditListener();
            this.container.trigger('change');
        },

    };
    items.init();
});
// ]]>
</script>
@endsection