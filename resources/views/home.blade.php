@extends('layouts.app')

@section('content')
<div class="container">
    @if (count($errors))
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    @foreach ($errors->all() as $error)
                        <p><strong>Ошибка:</strong> {{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="btn-group pull-right m-l-5">
                        <button class="btn btn-default btn-sm bot-settings-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-cog" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu p-l-5 p-r-5">
                            <li class="m-b-5{{ !count($bots) ? ' hidden' : '' }}">
                                <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#bot-edit-modal">
                                    изменить <i class="fa fa-pencil m-l-5 text-primary" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="m-b-5{{ !count($bots) ? ' hidden' : '' }}">
                                <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#bot-delete-modal">
                                    удалить <i class="fa fa-trash m-l-5 text-danger" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li>
                                <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#bot-create-modal">
                                    создать <i class="fa fa-plus m-l-5 text-success" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <select class="form-control input-sm bot-selector pull-right" name="" id=""{{ !count($bots) ? ' disabled' : '' }}>
                        @if (count($bots))
                            @foreach ($bots as $bot)
                                <option value="{{ $bot->id }}"{{ $bot->active ? ' selected' : '' }}>{{ $bot->name }}</option>
                            @endforeach
                        @else
                            <option>боты не созданы</option>
                        @endif
                    </select>
                    <div class="panel-title m-t-5 clearfix">Панель управления</div>
                </div>

                <div class="panel-body">
                    <p{!! count($bots) ? ' class="hidden"' : '' !!}>У вас пока нет ботов. Создайте бота для начала работы.</p>
                    <div class="bot-controls{{ !count($bots) ? ' hidden' : '' }}">
                        <div class="row p-b-20">
                            <div class="col-xs-12">
                                <object class="cam-preload" data="{{ isset($activeBot['url']) ? 'http://' . Auth::user()->name . ':' . $activeBot['password'] . '@' . $activeBot['url'] . ':8080/?action=snapshot' : '' }}" type="image/jpg"></object>
                                <div class="cam-view">
                                    <div class="bot-console">
                                        <div class="bot-console-string">
                                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                                            <span class="blink">_</span>
                                        </div>
                                        <div class="bot-console-string">&nbsp;</div>
                                        <div class="bot-console-string">&nbsp;</div>
                                        <div class="bot-console-string">&nbsp;</div>
                                        <div class="bot-console-string">&nbsp;</div>
                                        <div class="bot-console-string">&nbsp;</div>
                                    </div>
                                    <img class="img-responsive cam-default" src="img/cam-default-03.jpg" alt="" />
                                    <object class="img-responsive cam-stream" data="{{ isset($activeBot['url']) ? 'http://' . Auth::user()->name . ':' . $activeBot['password'] . '@' . $activeBot['url'] . ':8080/?action=stream' : '' }}" type="image/jpg"></object>
                                    <div class="cam-rotate-horizontal">
                                        <input type="text" data-slider-min="-90" data-slider-max="90" data-slider-step="1" data-slider-value="0" />
                                    </div>
                                    <div class="cam-rotate-vertical">
                                        <input type="text" data-slider-min="-90" data-slider-max="90" data-slider-step="1" data-slider-value="0" data-slider-orientation="vertical" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row p-b-20">
                            <div class="col-xs-2"></div>
                            <div class="col-xs-2">
                                <div class="btn-group-justified">
                                    <a class="btn btn-default bot-action-btn" data-code="87" data-action="mf" data-name="move forward" data-password="gR@Yr0$e" data-url="{{ isset($activeBot['url']) ? $activeBot['url'] : '' }}" data-id="">
                                        <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="btn-group-justified">
                                    <a class="btn btn-default bot-action-btn" data-code="65" data-action="ml" data-name="turn left" data-password="gR@Yr0$e" data-url="{{ isset($activeBot['url']) ? $activeBot['url'] : '' }}" data-id="">
                                        <i class="fa fa-rotate-left" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="btn-group-justified">
                                    <a class="btn btn-default bot-action-btn" data-code="83" data-action="mb" data-name="move backward" data-password="gR@Yr0$e" data-url="{{ isset($activeBot['url']) ? $activeBot['url'] : '' }}" data-id="">
                                        <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="btn-group-justified">
                                    <a class="btn btn-default bot-action-btn" data-code="68" data-action="mr" data-name="turn right" data-password="gR@Yr0$e" data-url="{{ isset($activeBot['url']) ? $activeBot['url'] : '' }}" data-id="">
                                        <i class="fa fa-rotate-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="bot-edit-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <img src="https://cdn2.iconfinder.com/data/icons/botcons/100/android-bot-round-point-eye-virus-dark-20.png">
                    Изменение настроек бота
                </h4>
            </div>
            <form class="bot-edit-form" action="{{ action('BotController@update', ['id' => count($bots) ? $bots->where('active', 1)->first()->id : 0]) }}" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-4">
                            <label>*Имя</label>
                            <input type="text" name="name" value="{{ count($bots) ? $bots->where('active', 1)->first()->name : '' }}" class="form-control">
                        </div>
                        <div class="col-xs-4">
                            <label>*Адрес</label>
                            <input type="text" name="url" value="{{ count($bots) ? $bots->where('active', 1)->first()->url : '' }}" class="form-control">
                        </div>
                        <div class="col-xs-4">
                            <label>Пароль</label>
                            <input type="text" name="password" value="{{ count($bots) ? $bots->where('active', 1)->first()->password : '' }}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary btn-sm">Сохранить</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="bot-delete-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <img src="https://cdn2.iconfinder.com/data/icons/botcons/100/android-bot-round-point-eye-virus-dark-20.png">
                    Удаление бота
                </h4>
            </div>
            <form action="{{ action('BotController@destroy', ['id' => count($bots) ? $bots->where('active', 1)->first()->id : 0]) }}" method="post">
                <div class="modal-body">
                    Вы действительно хотите удалить бота "{{ count($bots) ? $bots->where('active', 1)->first()->name : '' }}"?
                </div>
                <div class="modal-footer">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="bot-create-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <img src="https://cdn2.iconfinder.com/data/icons/botcons/100/android-bot-round-point-eye-virus-dark-20.png">
                    Создание нового бота
                </h4>
            </div>
            <form action="{{ action('BotController@store') }}" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-4">
                            <label>*Имя</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="col-xs-4">
                            <label>*Адрес</label>
                            <input type="text" name="url" class="form-control">
                        </div>
                        <div class="col-xs-4">
                            <label>Пароль</label>
                            <input type="text" name="password" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-success btn-sm">Создать</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
