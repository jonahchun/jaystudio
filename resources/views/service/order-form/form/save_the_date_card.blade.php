@extends('layouts.app')

@section('content')

    <save-the-date-form
        :form_action="'{{ route('service.order-form.save', ['service' => $service]) }}'"
        :sizes="{{ \App\Card\Model\Size::where('card_type', \App\Card\Model\Source\Type::STD)->orderBy('sort_order', 'asc')->get() }}"
        :formats="{{ json_encode(\App\Card\Model\Source\Format::getInstance()->getOptions()) }}"
        :templates="{{ \App\Card\Model\Template::where('card_type', \App\Card\Model\Source\Type::STD)->orderBy('sort_order', 'asc')->get() }}"
        :front_side_type="{{ \App\Card\Model\Source\SideType::FRONT }}"
        :back_side_type="{{ \App\Card\Model\Source\SideType::BACK }}"
        :locations="{{ \App\Core\Model\PickupLocation::orderBy('sort_order', 'asc')->get() }}"
    ></save-the-date-form>

@endsection
