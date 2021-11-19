@extends('admin.layouts.print')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-header-title">{{ __('Details') }}</h4>
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
                    @foreach($customer->newlywed_detail->question_answers as $questionId => $answer)
                        @if($question = \App\Core\Model\Question::find($questionId))
                        <tr>
                            <td style="white-space:normal;width:50%;"><strong>{{ $question->question }}</strong></td>
                            <td style="white-space:normal;width:50%;">{{ $answer }}</td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-header-title">{{ __('Additional Comment') }}</h4>
            </div>
            <div class="card-body">
               <div class="card-comment">
                   {{ $customer->newlywed_detail->comment }}
               </div>
            </div>
        </div>
    </div>
</div>
@endsection
