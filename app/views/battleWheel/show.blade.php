@extends('masterBlank')

@section('title')
    @lang('auth.title.login')
@stop

@section('header')
    {{ HTML::script('Scion_Battle_Wheel/SprySlidingPanels.js'); }}
    {{ HTML::script('Scion_Battle_Wheel/dom-drag.js'); }}
    {{ HTML::script('Scion_Battle_Wheel/counterClass.js'); }}
    {{ HTML::script('Scion_Battle_Wheel/counterPicker.js'); }}
    {{ HTML::script('Scion_Battle_Wheel/cjl_cookie.js'); }}
    {{ HTML::script('Scion_Battle_Wheel/js/session.js'); }}
    {{ HTML::style('Scion_Battle_Wheel/SprySlidingPanels.css'); }}
    {{ HTML::style('Scion_Battle_Wheel/style.css'); }}
    {{ HTML::script('Scion_Battle_Wheel/js/load.js'); }}
    {{ HTML::script('Scion_Battle_Wheel/progress.js'); }}
@stop

@section('content')
    <div id="bar_window" style="position: absolute; top: 214.667px; left: 465px; border: 2px solid blue; background-color: white; width: 350px; height: 80px; color: gray; z-index: 999999; visibility: hidden;" onclick="close_bar()">
            <div style="position: absolute;top: 0px; left: 0px; width: 347px; background-color: white; color: gray; text-align: right;">[X]</div>
            <div id="empty_bar" style="position: absolute;top: 25px;left: 25px;border: 1px solid blue;background-color: black;width: 301px;height: 30px;"></div>
            <div id="bar" style="position: absolute; top: 26px; left: 26px; background-color: blue; width: 583px; height: 30px;"></div>
            <div id="percent" style="position: absolute; top: 25px; width: 350px; text-align: center; vertical-align: middle; color: gray; font-size: 30px; ">100%</div>
        </div>
        
        <script language="JavaScript1.3" src="Scion%20Battle%20Wheel_fichiers/colorpicker.js"></script>
        <script>
        function toggleLockStatus(obj) {
            if (obj.className === 'locked') {
                obj.className = 'unlocked';
                obj.src = 'unlocked.bmp';
            }
            else {
                obj.className = 'locked';
                obj.src = 'locked.bmp';
            }
        }
        </script>
        
        <div>
            <div id="wheel">
                {{ HTML::image('Scion_Battle_Wheel/tiggerherz_wheel.jpg', null, array('id' => 'wheelImg')) }}
            </div> <!-- wheel -->

            <div id="gallery">
                <div style="overflow: hidden;" id="panels" class="SlidingPanels">
                    <div style="left: 0px; top: 0px;" class="SlidingPanelsContentGroup">
                        @foreach ($user->categories->sortBy('name') as $category)
                            <div id="{{ $category->name }}" class="SlidingPanelsContent SlidingPanelsCurrentPanel">
                                <h2>{{ $category->name }}</h2>
                                <?php $count = 0; ?>
                                @foreach ($category->icons as $icon)
                                    <?php $jsId = $icon->name.$count; ?>
                                    <div class="counterPic" id="{{ $jsId }}">
                                        <img src="{{ URL::action('IconController@image', array($icon->category_id, $icon->id)) }}" class="iconImg" />
                                        <div class="handle"></div>
                                        <textarea value="" class="iconText"></textarea>
                                        <input value="{{ $icon->name }}" class="iconInput" id="iconInput{{ $jsId }}" style="background-color: #ffe03d;" type="text" />
                                        {{ HTML::image('Scion_Battle_Wheel/redX.jpg', null, array('class' => 'redX', 'onclick' => "this.parentNode.parentNode.removeChild(this.parentNode);")) }}
                                        {{ HTML::image('Scion_Battle_Wheel/unlocked.jpg', null, array('class' => 'unlocked', 'onclick' => "toggleLockStatus(this); return false;")) }}
                                    </div> <!-- counterPic -->
                                    <script>
                                        cp_init("iconInput{{ $jsId }}");
                                    </script>
                                <?php $count++; ?>
                                @endforeach
                            </div> <!-- {{ $category->name }} -->
                        @endforeach
 

                    </div> <!-- SlidingPanelsContentGroup -->
		</div> <!-- panels -->
            </div> <!-- gallery -->
            
            <div id="galleryNav">
		<form name="navForm">
                    <a href="#" onclick="sp1.showFirstPanel(); return false;">&lt;&lt;</a> | 
                    <a href="#" onclick="sp1.showPreviousPanel(); return false;">&lt;</a> | 
                    <select name="gallerySelect" onchange="sp1.showPanel(this.value);">
                        @foreach ($user->categories->sortBy('name') as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <a href="#" onclick="sp1.showNextPanel(); return false;">&gt;</a> | 
                    <a href="#" onclick="sp1.showLastPanel(); return false;">&gt;&gt;</a>
		</form>
            </div> <!-- galleryNav -->

            <script type="text/javascript">
                    var sp1 = new Spry.Widget.SlidingPanels("panels");
            </script>
	
            <div id="instructions">
                <h2>Instructions</h2>
                <ul>
                    <li>Click on an icon in the gallery to create a duplicate.</li>
                    <li>Drag and drop the icons around the wheel.</li>
                    <li>Icon names are edittable. You may also right click to change the background color of a name.</li>
                    <li>The wheel dropdown list offers multiple choices for battle wheel images.</li>
                    <li>The style dropdown list changes the counter format.</li>
                    <li><a href="pages/">Admin panel</a></li>
                </ul>
            </div>  <!-- instructions -->
	
            <div class="controls">
                <script type="text/javascript">
                    function setCounters(newType) {
                        // find all icon images 
                        var arr = document.getElementsByTagName('div');
                        for(var i = 0; i < arr.length; i++) {
                            if(/counter/i.test(arr[i].className)) {
                                // see if it's locked
                                for (var j = 0; j < arr[i].childNodes.length; j++){
                                    if (arr[i].childNodes[j].className==="unlocked") {
                                        arr[i].className = newType;
                                        break;
                                    }
                                }
                            }
                        }

                        // set size of default text area
                        if (newType === 'counterText') {
                            document.getElementById('defaultTextArea').style.width = '50px';
                            document.getElementById('defaultTextArea').style.height = '42px';
                        }
                        else if (newType === 'counterLargeText') {
                            document.getElementById('defaultTextArea').style.width = '70px';
                            document.getElementById('defaultTextArea').style.height = '62px';
                        }

                    }
                </script>

                Wheel: 
                <select id="wheelSelect" onchange="document.getElementById('wheelImg').src = 'Scion_Battle_Wheel/' + this.value + '.jpg';">
                    <option value="exalted_wheel">Exalted</option>
                    <option value="exalted_wheel_large">Exalted (Large)</option>
                    <option value="kuhan_wheel">Kuhan</option>
                    <option value="kuhan_wheel_large">Kuhan (large)</option>
                    <option value="tiggerherz_wheel" selected="selected">Tiggerherz</option>
                    <option value="tiggerherz_wheel_big">Tiggerherz (large)</option>
                    <option value="voidstate_wheel">Voidstate</option>
                </select>
                Style: 
                <select onchange="setCounters(this.value);">
                    <option value="counterText">Show Text</option>
                    <option value="counterLargeText">Show More Text</option>
                    <option value="counterPic" selected="selected">Show Pics</option>
                    <option value="counterHandled">Handle Only</option>
                </select>  
                <br /><br />

                <input value="Save Session" onclick="saveSession();" type="button" />
                <div id="result"></div> <!-- placeholder for ajax response -->
            </div> <!-- controls -->
        </div>

        <div id="defaultTextDiv">
            <center>
                <table border="0">
                    <tbody>
                        <tr>
                            <td id="defaultTextLabel">
                                Default Text for Counters
                            </td>
                            <td>
                                <textarea id="defaultTextArea"></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </center>
        </div> <!-- defaultTextDiv -->

        <div class="props">
            Scion, Exalted, and associated Icon artwork Copyright (c) <a href="http://www.white-wolf.com/">White Wolf</a><br>
            Wheels by Kuhan, Tiggerherz, Voidstate, and White Wolf<br>
            Got a questionn, comment, or request? Send it to <a href="mailto:james.t.mcmurray@gmail.com?subject=Scion%20Battle%20Wheel">yours truly</a>.
            If you've got a pic you want to see up, or a good source for art, please <a href="mailto:james.t.mcmurray@gmail.com?subject=Scion%20Battle%20Wheel:%20Art">let me know</a>.
        </div>
@stop