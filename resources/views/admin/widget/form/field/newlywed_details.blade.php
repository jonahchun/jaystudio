@if($form->getInstance()->newlywed_detail)
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                @includeIf('admin::widget.button', [
                    'jsaction' => 'window.open("' . route('admin.customer.print.newlywed-details', ['customer' => $form->getInstance()->id]) . '")', 
                    'label'    => 'Print',
                    'route'    => 'admin.customer.print.newlywed-details',
                ])        
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Answer</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach(\App\Core\Model\Question::all() as $question)
                        <tr>
                            <td style="white-space:normal;width:50%;"><strong>{{ $question->question }}</strong></td>
                            <td style="white-space:normal;width:50%;">{{ optional($value)[$question->id] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif