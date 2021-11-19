@php
    $page = $form->getInstance();
    $value = $page->edit_mode == \WFN\CMS\Model\Source\EditMode::ADVANCED ? '' : $value;
@endphp
<div class="row">
    <label for="basic-select" class="col-sm-3 col-form-label">Edit Mode</label>
    <div class="col-sm-9">
        <select name="edit_mode" class="form-control">
        @foreach(\WFN\CMS\Model\Source\EditMode::getInstance()->getOptions() as $_value => $_label)
            <option value="{{ $_value }}" @if($page->edit_mode == $_value) selected="selected" @endif>{{ $_label }}</option>
        @endforeach
        </select>
    </div>
</div>
<hr />
<div class="row" id="editor-default">
    <div class="col-sm-12">
        @include('admin::widget.form.field.wysiwyg')
    </div>
</div>
<div class="row" id="editor-advanced">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <button type="button" class="btn btn-primary waves-effect waves-light dropdown-toggle" data-type="dropdown">
                        Add Block
                    </button>
                    <div class="dropdown-menu">
                    @foreach(\WFN\CMS\Model\Source\AdvancedBlocks::getInstance()->getOptions() as $_value => $_label)
                        <a href="javascript:void(0);" data-type="{{ $_value }}" class="dropdown-item">{{ $_label }}</a>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 blocks">
    @if($page->edit_mode == \WFN\CMS\Model\Source\EditMode::ADVANCED && is_array($page->getAdvancedContent()))
        @php
            $blocks = config('blocks', []);
        @endphp
        @foreach($page->getAdvancedContent() as $data)
            @php
                $keys = array_keys($data);
                $blockId = array_shift($keys);
                $values = $data;
                $blockData = $blocks[$blockId];
                $blockData['key'] = $blockId;
            @endphp
            @include('admin.widget.form.advanced.block')
        @endforeach
    @endif
    </div>
</div>
<script type="text/javascript">
var advancedMode = {
    initiated: false,
    init: function() {
        if(this.initiated) {
            return false;
        }
        this.initiated = true;
        $('label[for="basic-editor"]').hide();
        this.defaultEditor = $('#editor-default');
        this.advancedEditor = $('#editor-advanced');
        this.switcher = $('select[name="edit_mode"]');
        this.switcher.change(this.switchMode.bind(this));
        this.switcher.trigger('change');
        this.advancedEditor.find('[data-type="dropdown"]').click(function() {
            $(this).next().toggle();
        });
        this.advancedEditor.find('a.dropdown-item').click(this.addBlock.bind(this));
        this._initControls();
        this.advancedEditor.find('a[data-type="hide"]').trigger('click');
    },
    switchMode: function() {
        var mode = this.switcher.val();
        if(mode == {{ \WFN\CMS\Model\Source\EditMode::ADVANCED }}) {
            this.defaultEditor.hide();
            this.advancedEditor.show();
            this.defaultEditor.find('textarea').attr('disabled', 'disabled');
            this.advancedEditor.find('input').attr('disabled', false);
            this.advancedEditor.find('textarea').attr('disabled', false);
            this.advancedEditor.find('select').attr('disabled', false);
        } else {
            this.defaultEditor.show();
            this.advancedEditor.hide();
            this.defaultEditor.find('textarea').attr('disabled', false);
            this.advancedEditor.find('input').attr('disabled', 'disabled');
            this.advancedEditor.find('textarea').attr('disabled', 'disabled');
            this.advancedEditor.find('select').attr('disabled', 'disabled');
        }
    },
    addBlock: function(event) {
        var block_id = $(event.target).data('type');
        $(event.target).parent().hide();
        var url = "{{ route('admin.cms.editor.block.html', ['block_id' => '__block_id__']) }}".replace('__block_id__', block_id);
        var _this = this;
        $.ajax({
            url: url,
            success: function(response) {
                _this.advancedEditor.find('div.blocks').append(response);
                _this._initControls();
            },
        })
    },
    _initControls: function() {
        this.advancedEditor.find('a[data-type="remove"]').click(this.removeBlock.bind(this));
        this.advancedEditor.find('a[data-type="up"]').click(this.moveBlockUp.bind(this));
        this.advancedEditor.find('a[data-type="down"]').click(this.moveBlockDown.bind(this));
        this.advancedEditor.find('a[data-type="show"]').click(this.showBlock.bind(this));
        this.advancedEditor.find('a[data-type="hide"]').click(this.hideBlock.bind(this));
    },
    removeBlock: function(event) {
        $(event.target).parents('.row').first().remove();
    },
    moveBlockUp: function(event) {
        var block = $(event.target).parents('.row').first();
        if(block.prev().length) {
            block.insertBefore(block.prev());
        }
    },
    moveBlockDown: function(event) {
        var block = $(event.target).parents('.row').first();
        if(block.next().length) {
            block.insertAfter(block.next());
        }
    },
    showBlock: function(event) {
        $(event.target).parents('.row').first().find('.card-body').show();
        $(event.target).parents('.btn-group').first().find('[data-type="hide"]').show();
        $(event.target).parents('.btn-group').first().find('[data-type="show"]').hide();

    },
    hideBlock: function(event) {
        $(event.target).parents('.row').first().find('.card-body').hide();
        $(event.target).parents('.btn-group').first().find('[data-type="hide"]').hide();
        $(event.target).parents('.btn-group').first().find('[data-type="show"]').show();
    },
};
$(function() {
    advancedMode.init();
});
</script>