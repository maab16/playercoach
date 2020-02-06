@extends('layouts.master')

@section('title')
    Court Booking
@stop

@section('head')
    {{Html::style('assets/modules/fullcalendar-scheduler-1.9.4/lib/fullcalendar.min.css')}}
    {{Html::style('assets/modules/fullcalendar-scheduler-1.9.4/scheduler.min.css')}}
    {!! Theme::css('css/customcalendar.css') !!}





    {!! Theme::js('js/moment.min.js') !!}
    {!! Theme::js('plugins/jquery/dist/jquery.min.js') !!}


    {{--<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>--}}
    <script type="text/javascript" src="/assets/modules/fullcalendar-scheduler-1.9.4/lib/fullcalendar.min.js"></script>
    <script type="text/javascript" src="/assets/modules/fullcalendar-scheduler-1.9.4/scheduler.min.js"></script>
    {!! Theme::js('js/zConfirm.min.js', ['id'=>'PSZ_Library_Loader']) !!}
    {!! Theme::js('js/bookcourt.min.js') !!}




@endsection

@section('content')

                @if(isset($calendar))

                    {!! $calendar->calendar() !!}
                    {!! $calendar->script() !!}

                    <div class="modal fade" id="newbooking">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button class="close" data-dismiss="modal">&times</button>
                                    <h1 class="modal-title">Book court</h1>
                                </div><!-- end of modal header -->
                                <div class="modal-body">
                                    <p>You are requesting <span id="resourcename"></span> on <span id="bookingday"></span> from <span id="bookingstart"></span> to <span id="bookingend"></span> ? </p>

                                    {{ Form::open(array('id'=>'bookcourt_form', 'route'=>'bookcourt')) }}
                                    <input name="start" type="hidden" id="start1" value="" />
                                    <input name="end" type="hidden" id="end2" value="" />
                                    <input name="resourceId" type="hidden" id="resourceId" value="" />
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label for="practice_type" class="col-form-label">Practice type:</label>
                                            {{ Form::select('booking _type', [
                                            //'' => 'Please Select',
                                            'open' => 'Open (others can join)',
                                            'closed' => 'Closed (only you can add people)',
                                            ], 'open', ['class'=>'form-control', 'id'=>'booking_type']
                                            )}}
                                        @if ($errors->has('booking_type'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('booking_type') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group" id="group_maxreg">
                                            <label class="col-md-4 control-label">Max Registrants:</label>
                                            <div class="input-group col-md-5">
                                                <select name="max_reg" class="form-control">
                                                    <option value="0">Please select</option>
                                                    <option value="1">1 (Solo Practice)</option>
                                                    <option value="2">2 (Singles)</option>
                                                    <option value="3">3 (2on1)</option>
                                                    <option value="4">4 (doubles)</option>

                                                </select>
                                            </div>
                                        @if ($errors->has('max_reg'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('max_reg') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-5">

                                        {!! CoralsForm::select('user_id[]','CourtBooking::attributes.booking.add_players', [], true, null,
                         array_merge(['class'=>'select2-ajax','data'=>[
                         'model'=>\Corals\User\Models\User::class,
                         'columns'=> json_encode(['name', 'last_name']),
                         'selected'=>json_encode(user()->id),
                         'where'=>json_encode([]),
                         ]],['multiple'=>'multiple']),'select2')
                    !!}
                                        </div>
                                    </div>
                                    {{ Form::submit('Book it!', array('class' => 'btn', 'id'=>'submitprivate')) }}


                                    {{ Form::close() }}



                                </div><!-- end of modal body -->
                            </div><!-- end modal content -->
                        </div><!--end modal-dialog -->
                    </div><!--end bookcourt Modal; -->

                    <div class="modal fade" id="joincourt">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button class="close" data-dismiss="modal">&times</button>
                                    <h1 class="modal-title">Join Group</h1>
                                </div><!-- end of modal header -->
                                <div class="modal-body">
                                    <p>Are you sure you want to join this group on <span id="day"></span> from <span id="startgroup"></span> to <span id="endgroup"></span> ? </p>

                                    {{ Form::open(array('id'=>'joingroup_form', 'route'=>'joingroup')) }}
                                    {{ Form::hidden('bookingid', null, array('id' => 'bookingid')) }}
                                    @if ($errors->has('bookingid'))
                                        <span class="help-block">
                                                    <strong>{{ $errors->first('bookingid') }}</strong>
                                                </span>
                                    @endif
                                    {{ Form::submit('Join Group!', array('class' => 'btn', 'id'=>'submitjoingroup')) }}
                                    {{ Form::close() }}


                                </div>
                            </div>
                        </div>
                    </div>
                @endif

@endsection





@section('footer')
    <script type="text/javascript">
        $(document).ready(function() {

            $("#addtogroup").click(function() {

            });
        });



    </script>

@endsection