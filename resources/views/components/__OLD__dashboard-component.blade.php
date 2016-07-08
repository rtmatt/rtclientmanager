<div class="RT-Client_Dashboard" id="js--Client-Dashboard{!!isset($dashboard_id)?'_'.$dashboard_id:''!!}">
    <section class='StatusBar'>
        <a class='BrandBar' href="" target="blank">
            <div class='BrandBar__logo'></div>
        </a>
        <div class='MonthlyUsage'>
            <div class='StatusBar__sectionLabel'>
                <img src='/images/icon-clock.png' alt='Monthly Hours'>
                <span>Monthly<br>Usage</span>
            </div>
            <div class="MonthWrap js--months">
                <div class="FirstSixMonths">
                    @foreach($dashboard_data->monthly as $key=>$month)
                        @if($key<6)
                            <div class="month{!!$month->is_current_month?' HourSphere--currentMonth':''!!}"
                                 data-percent_used="{{$month->percentage_used}}"
                                 data-hours_used="{{$month->hours_used}}">
                                <span class="month0-name js--Month-Name">{{$month->name}}</span>
                                <div class="sphere"></div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="LastSixMonths">
                    @foreach($dashboard_data->monthly as $key=>$month)
                        @if($key>=6)
                            <div class="month{!!$month->is_current_month?' HourSphere--currentMonth':''!!}"
                                 data-percent_used="{{$month->percentage_used}}"
                                 data-hours_used="{{$month->hours_used}}">
                                <span class="month0-name js--Month-Name">{{$month->name}}</span>
                                <div class="sphere"></div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class='YearUsage'>
            <div class='StatusBar__sectionLabel'>
                <img src='/images/icon-calendar.png' alt='Yearly Balance'>
                <span>Yearly<br>Balance</span>
            </div>
            <div class="bar-hold js--annual_usage"
                 data-year_percent_used="{{$dashboard_data->annual->percentage_used}}"
                    data-year_hours_available="{{$dashboard_data->annual->hours_available}}"
                    data-year_hours_used="{{$dashboard_data->annual->hours_used}}">
                <div class="bar-wrap">
                    <div class="BalanceBar">
                        <div class="BalanceBar__currentProgress js--Dashboard__annual-usage-progress"
                             data-usage="{{$dashboard_data->annual->percentage_used}}"></div>
                    </div>
                    <div class="CurrentYearlyHoursSphere js--Dashboard__annual-usage-value">
                        <div class="hour-hold">
                            <span class="full-center">{{$dashboard_data->annual->hours_used}}</span>
                        </div>
                    </div>
                    <div class="TotalYearlyHoursSphere">
                        <div class="hour-hold">
                            <span class="full-center js--AnnualHoursAvailable">{{$dashboard_data->annual->hours_available}}</span>
                        </div>
                    </div>
                </div>
                <!-- END OF: 'bar-wrap' -->
            </div>
            <!-- END OF: 'BalanceBar' -->
        </div>
        <!-- END OF: 'YearUsage' -->


        <!-- ClinetServices: Last Backup, Monthly Services, Priority Alert -->
        <div class="ClientServices">

            <div class="LastBackup">
                <div class="full-center">
                    <div class="ClientServices__sectionLabel">
                        <img src="/images/icon-shield.png" alt="Last Backup">
                        <span>Last <br>Backup</span>
                        <div class="LastBackup__timeStamp js--Last-Backup-Text">{{$dashboard_data->last_backup}}</div>
                    </div>
                </div>
            </div>
            @if(isset($admin_mode))
                <a class="MonthlyServices js--Log-Backup-Button" ng-click="clientDashboardController.logBackup()">
                    <div class="full-center">
                        <div class="ClientServices__sectionLabel">
                            <img class="backup_icon" src="/images/icon-clock.svg" alt="Client Services">
                            <span>Log <br>Backup</span>
                        </div>
                    </div>
                </a>
            @else
                <a href="" class="MonthlyServices">
                    <div class="full-center">
                        <div class="ClientServices__sectionLabel">
                            <img src="/images/icon-document.png" alt="Client Services">
                            <span>View Detailed <br>Monthly Services</span>
                        </div>
                    </div>
                </a>
            @endif
            <div class="PriorityAlert PriorityAlert-Toggle js--Dashboard__alert-toggle">
                <div class="ClientServices__sectionLabel sectionLabel--white sectionLabel--tableCellCenter">
                    @if(isset($admin_mode))
                        <img src="/images/icon-edit.svg" data-alt-src="/images/icon-x.png" alt="Edit"
                             class="PriorityAlert-Toggle__icon">
                        <span class="PriorityAlert-Toggle__text" data-toggle-template="Close">Edit</span>
                    @else
                        <img src="/images/icon-alert.png" data-alt-src="/images/icon-x.png" alt="Priority Alert"
                             class="PriorityAlert-Toggle__icon">
                        <span class="PriorityAlert-Toggle__text" data-toggle-template="Close">Priority Alert</span>
                    @endif
                </div>
            </div>

        </div>
        <!-- END OF: 'ClientServices' -->
    </section>


    <!-- PRIORITY ALERT FORM -->
    <section class="PriorityAlertForm js--Dashboard__alert-form">
        @if(isset($admin_mode))
            @include('rtdashboard::partials.edit-form')
        @else
            <form action="" method="post" class="js--Dashboard-Alert-Form" enctype="multipart/form-data">


                <div class="IssueCol">

                    <fieldset class="PriorityDescription">
                        <ul>
                            <li>
                                <label for="actualHappening">What's happening is</label>
                                <textarea id="actualHappening" name="actual"></textarea>
                            </li>
                            <li>
                                <label for="expectedToHappen">What should happen is</label>
                                <textarea id="expectedToHappen" name="expected"></textarea>
                            </li>
                        </ul>
                    </fieldset>

                    <fieldset class="PriorityDetails">
                        <label>This happens</label>
                        <ul class="RadioButtonList">
                            <li>
                                <input type="radio" id="frequencyEveryTime" name="frequency" value="always">
                                <label for="frequencyEveryTime">Every time</label>
                            </li>
                            <li>
                                <input type="radio" id="frequencyOften" name="frequency" value="often">
                                <label for="frequencyOften">Often</label>
                            </li>
                            <li>
                                <input type="radio" id="frequencyOccasionally" name="frequency" value="occasionally">
                                <label for="frequencyOccasionally">Occasionally</label>
                            </li>
                            <li>
                                <input type="radio" id="frequencyOnlyOnce" name="frequency" value="once">
                                <label for="frequencyOnlyOnce">Only once</label>
                            </li>
                        </ul>

                        <label>When using</label>
                        <ul class="UserDeviceWrap">
                            <li>
                                <input type="text" id="userDevice" name="user_device"
                                       placeholder="Device (Mac, iPhone, Windows10...)">
                            </li>
                            <li>
                                <input type="text" id="userOS" name="user_browser"
                                       placeholder="Browser (Firefox, Safari, Chrome...)">
                            </li>
                            <li>
                                <input type="text" id="userBrowser" name="user_browser_ver"
                                       placeholder="Browser Version">
                            </li>
                        </ul>
                        <button class="detectUserSettings u--float-right-md">Detect for me</button>

                        <!-- Clear floated content -->
                        <div class="clear"></div>

                        <label>Attach Screenshot</label>
                        <input type="file" id="fileAttach" name="attachment" placeholder="Upload screenshot">
                    </fieldset>

                </div>
                <!-- END OF: 'IssueCol' -->
                <div class="ContactInfoCol">

                    <fieldset class="PriorityContact">
                        <span>Who should we contact about this?</span>

                        <label for="userName">Name</label>
                        <input type="text" id="userName" name="contact_name">

                        <label for="userEmail">Email</label>
                        <input type="email" id="userEmail" name="contact_email">

                        <label for="userPhone">Phone</label>
                        <input type="tel" id="userPhone" name="contact_phone">

                        <span>Is there anything else we should know?</span>
                        <textarea id="anything-else" name="additional_info"></textarea>
                    </fieldset>

                    <button class="u--float-right-md" type="submit">Submit</button>
                </div>
            </form>
            @endif

                    <!-- END OF: 'ContactInfoCol' -->
    </section>
    <!-- END OF: 'PriorityAlertForm' -->

</div>