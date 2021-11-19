@extends('layouts.app')

@section('content')

    <thank-you-card-form
        :form_action="'{{ route('service.order-form.save', ['service' => $service]) }}'"
        :card_layout_types="{{ json_encode(\App\Card\Model\Source\LayoutType::getInstance()->getOptionsArray()) }}"
        :folded_card_layout_type="{{ \App\Card\Model\Source\LayoutType::FOLDED }}"
        :sizes="{{ \App\Card\Model\Size::where('card_type', \App\Card\Model\Source\Type::TYC)->orderBy('sort_order', 'asc')->get() }}"
        :formats="{{ json_encode(\App\Card\Model\Source\Format::getInstance()->getOptions()) }}"
        :templates="{{ \App\Card\Model\Template::where('card_type', \App\Card\Model\Source\Type::TYC)->orderBy('sort_order', 'asc')->get() }}"
        :front_side_type="{{ \App\Card\Model\Source\SideType::FRONT }}"
        :back_side_type="{{ \App\Card\Model\Source\SideType::BACK }}"
        :inside_side_type="{{ \App\Card\Model\Source\SideType::INSIDE }}"
        :locations="{{ \App\Core\Model\PickupLocation::orderBy('sort_order', 'asc')->get() }}"
    ></thank-you-card-form>

@endsection



