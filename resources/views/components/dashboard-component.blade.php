<div class="RT-Client_Dashboard" id="js--Client-Dashboard{!!isset($dashboard_id)?'_'.$dashboard_id:''!!}">
    <!-- Monthly Services Modal -->
    <div class="modal fade js--Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close modal-close-btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Detailed Monthly Benefits</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="services-icon">
                        <img src="/images/discount.svg" alt="Some icon">
                    </div>
                    <div class="services-content">
                        <div class="services-content-title">Discounted Rates</div>
                        <p class="services-content-body">
                            Save money on each service request and maximize your annual hours with 20% off the standard
                            hourly rate.
                        </p>
                    </div>
                </div>
                <div class="modal-body clearfix">
                    <div class="services-icon">
                        <img src="/images/alerts.svg" alt="Some icon">
                    </div>
                    <div class="services-content">
                        <div class="services-content-title">Priority Support</div>
                        <p class="services-content-body">
                            Access to our priority alert form gives you the highest priority turn-around times for all
                            service requests and project needs.
                        </p>
                    </div>
                </div>
                <div class="modal-body clearfix">
                    <div class="services-icon">
                        <img src="/images/monthlyreports.svg" alt="Some icon">
                    </div>
                    <div class="services-content">
                        <div class="services-content-title">Monthly Reports</div>
                        <p class="services-content-body">
                            Receive detailed monthly statistics regarding your website tra c, marketing strategy, sales
                            goals, and more.
                        </p>
                    </div>
                </div>
                <div class="modal-body clearfix">
                    <div class="services-icon">
                        <img src="/images/monitoring.svg" alt="Some icon">
                    </div>
                    <div class="services-content">
                        <div class="services-content-title">24/7 Monitoring</div>
                        <p class="services-content-body">
                            We monitor, update, and maintain your website’s server requirements and immediately respond
                            to
                            urgent noti cations.
                        </p>
                    </div>
                </div>
                <div class="modal-body clearfix">
                    <div class="services-icon">
                        <img src="/images/vps.svg" alt="Some icon">
                    </div>
                    <div class="services-content">
                        <div class="services-content-title">Virtual Private Server</div>
                        <p class="services-content-body">
                            Professional Virtual Private Servers (VPS) enable faster speeds, greater security, and
                            shorter
                            development times.
                        </p>
                    </div>
                </div>
                <div class="modal-body clearfix">
                    <div class="services-icon">
                        <img src="/images/billing.svg" alt="Some icon">
                    </div>
                    <div class="services-content">
                        <div class="services-content-title">Hassle-Free Billing</div>
                        <p class="services-content-body">
                            With one monthly invoice, don’t stress over multiple service requests, budget constraints,
                            or
                            unwanted surprises.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="RT-Dashboard__Status-bar">
        <a class='BrandBar' href="http://www.designledge.com/" target="blank">&nbsp;</a>
        <!-- This wrapper is for everything in the status bar except the brand bar -->
        <div class="StatusBarContent clearfix">
            <!-- This wrapper is for everything in the status bar except the brand bar -->
            <div class="UsageContent">
                <div class="UsageContent__row clearfix">
                    <div class="UsageContent__label UsageContent__label--monthly u--float-left-tablet-portrait-min">
                        <div class="DashboardIconLabel clearfix">
                            <img src='/images/icon-clock.png' class="DashboardIconLabel__icon" alt="Monthly Hours">
                            <span class="DashboardIconLabel__text DashboardIconLabel__text">Monthly<br> Usage</span>
                        </div>
                    </div>
                    <div class="UsageContent__content u--float-left-tablet-portrait-min">
                        <div class="MonthWrap clearfix">
                            @foreach($dashboard_data->monthly as $key=>$month)
                                <div class="month{!!$month->is_current_month?' current-month':''!!}"
                                     data-percent_used="{{$month->percentage_used}}"
                                     data-hours_used="{{$month->hours_used}}"
                                        data-hours_available="{{$month->hours_available}}">
                                    <span class="month-name js--Month-Name">{{$month->name}}</span>
                                    <div class="js--graph Month-Graph-Wrap" id="js--circle-{{$key}}"></div>
                                </div>
                            @endforeach
                        </div>
                        <!-- END OF: 'MonthWrap' -->
                    </div>
                </div>
                <div class="UsageContent__row clearfix">
                    <div class="UsageContent__label UsageContent__label--yearly u--float-left-tablet-portrait-min">
                        <div class="DashboardIconLabel clearfix">
                            <img src='/images/icon-calendar.png' class="DashboardIconLabel__icon" alt="Yearly Balance">
                            <span class="DashboardIconLabel__text">Yearly<br> Balance</span>
                        </div>
                    </div>
                    <div class="UsageContent__content u--float-left-tablet-portrait-min">
                        <div class="AnnualWrap js--annual_usage"
                             data-year_percent_used="{{$dashboard_data->annual->percentage_used}}"
                             data-year_hours_available="{{$dashboard_data->annual->hours_available}}"
                             data-year_hours_used="{{$dashboard_data->annual->hours_used}}">
                            <div class="CurrentHourBalance js--Dashboard__annual-usage-value">
                                <span class="CurrentHourBalance__balance">{{$dashboard_data->annual->hours_used}}</span>
                            </div>
                            <div class="BalanceBar js--Dashboard__annual-usage-progress"
                                 data-usage="{{$dashboard_data->annual->percentage_used}}"></div>
                            <div class="TotalAnnualHours">
                                <span class="TotalAnnualHours__total">{{$dashboard_data->annual->hours_available}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- This wrapper is for last backup, monthly services, priority alert -->
            <div class="StatusBarSecondaryContent clearfix">
                <!-- This wrapper is for the last backup and monthly services -->
                <div class="StatusBarSecondaryInformation u--float-left-tablet-portrait-min clearfix">
                    <div class="StatusBarSecondaryInformation__item clearfix">
                        <div class="u--inline-block">
                            <div class="DashboardIconLabel DashboardIconLabel--secondary-content clearfix u--float-left-tablet-portrait-min u--remove-float-desktop">
                                <img class="DashboardIconLabel__icon u--remove-float-desktop u--margin-auto-desktop"
                                     src='/images/icon-shield.png' alt="Last Backup">
                                <span class="DashboardIconLabel__text DashboardIconLabel__text--backup">Last Backup</span>
                            </div>
                            <p class="StatusBarSecondaryInformation__item-text u--remove-float-desktop clearfix js--Last-Backup-Text">
                                {{$dashboard_data->last_backup}}
                            </p>
                        </div>
                    </div>
                    {{--@todo: add in admin mode controls ln:82 in __old__dashbboard-component.blade.php--}}
                    <a class="StatusBarSecondaryInformation__item clearfix StatusBarSecondaryInformation__item--services js--Modal-Trigger"
                       href="#" data-toggle="modal" data-target="#myModal">
                        <div class="DashboardIconLabel DashboardIconLabel--secondary-content clearfix">
                            <img class="DashboardIconLabel__icon u--remove-float-desktop u--margin-auto-desktop"
                                 src='/images/icon-document.png' alt="Monthly Services">
                            <span class="DashboardIconLabel__text DashboardIconLabel__text--services">View Monthly<br>Benefits</span>
                        </div>
                    </a>
                </div>
                <a class="StatusBarAlertButton u--float-left-tablet-portrait-min js--Dashboard__alert-toggle" href="#">
                    <div class="DashboardIconLabel DashboardIconLabel--secondary-content u--full-center-desktop clearfix">
                        <img class="DashboardIconLabel__icon DashboardIconLabel__icon--priority js--PriorityAlert-Toggle__icon"
                             src='/images/icon-alert.png' data-alt-src="/images/icon-x.png" alt="Priority Alert">
                        <span class="DashboardIconLabel__text DashboardIconLabel__text--priority js--PriorityAlert-Toggle__text" data-toggle-template="Close">Priority Alert</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <section class="RT-Dashboard__Priority-form clearfix js--Dashboard__alert-form">
        <form class="js--Dashboard-Alert-Form" enctype="multipart/form-data">
            <div class="AlertFormIssueCol">
                <div class="AlertFormIssueCol__description u--bottom-margin-50-mobile-min">
                    <div class="AlertFormIssueCol__description-col">
                        <div class="AlertFormIssueCol__description-col-wrapper AlertFormIssueCol__description-col-wrapper--padding-right">
                            <label class="AlertIssueTitle" for="actualHappening">What's happening is</label>
                        <textarea class="AlertFormIssueCol__description-col-textarea" id="actualHappening" name="actual"
                                  required=""></textarea>
                        </div>
                    </div>
                    <div class="AlertFormIssueCol__description-col clearfix">
                        <div class="AlertFormIssueCol__description-col-wrapper AlertFormIssueCol__description-col-wrapper--padding-left">
                            <label class="AlertIssueTitle" for="expectedToHappen">What should happen is</label>
                        <textarea class="AlertFormIssueCol__description-col-textarea" id="expectedToHappen"
                                  name="expected" required=""></textarea>
                        </div>
                    </div>
                </div>
                <div class="AlertFormIssueCol__frequency u--bottom-margin-50-mobile-min clearfix">
                    <span class="AlertIssueTitle">This happens</span>
                    <div class="AlertFormIssueCol__frequency-options">
                        <div class="AlertFormIssueCol__frequency-options-wrapper">
                            <input class="AlertFormIssueCol__frequency-options-option" type="radio"
                                   id="frequencyEveryTime"
                                   name="frequency" value="always">
                            <label class="AlertFormIssueCol__frequency-options-label" for="frequencyEveryTime">Every
                                time
                            </label>
                        </div>
                        <div class="AlertFormIssueCol__frequency-options-wrapper">
                            <input class="AlertFormIssueCol__frequency-options-option" type="radio" id="frequencyOften"
                                   name="frequency" value="often">
                            <label class="AlertFormIssueCol__frequency-options-label" for="frequencyOften">Often</label>
                        </div>
                        <div class="AlertFormIssueCol__frequency-options-wrapper">
                            <input class="AlertFormIssueCol__frequency-options-option" type="radio"
                                   id="frequencyOccasionally" name="frequency" value="occasionally">
                            <label class="AlertFormIssueCol__frequency-options-label" for="frequencyOccasionally">
                                Occasionally
                            </label>
                        </div>
                        <div class="AlertFormIssueCol__frequency-options-wrapper">
                            <input class="AlertFormIssueCol__frequency-options-option" type="radio"
                                   id="frequencyOnlyOnce"
                                   name="frequency" value="once">
                            <label class="AlertFormIssueCol__frequency-options-label" for="frequencyOnlyOnce">Only once
                            </label>
                        </div>
                    </div>
                </div>
                <div class="AlertFormIssueCol__specs u--bottom-margin-50-mobile-min clearfix">
                    <span class="AlertIssueTitle">When using</span>
                    <div class="AlertFormIssueCol__specs-options">
                        <div class="AlertFormIssueCol__specs-options-wrapper">
                            <input class="AlertFormIssueCol__specs-input" type="text" id="userDevice" name="user_device"
                                   placeholder="Device (ie. iPhone, PC)">
                        </div>
                        <div class="AlertFormIssueCol__specs-options-wrapper">
                            <input class="AlertFormIssueCol__specs-input" type="text" id="userOS" name="user_browser"
                                   placeholder="Browser (ie. Chrome, Safari)">
                        </div>
                        <div class="AlertFormIssueCol__specs-options-wrapper">
                            <input class="AlertFormIssueCol__specs-input" type="text" id="userBrowser"
                                   name="user_browser_ver" placeholder="Browser Version">
                        </div>
                    </div>
                    <button type="button" class="AlertFormIssueCol__specs-detect">Detect for me</button>
                </div>
                <div class="AlertFormIssueCol__screenshot u--bottom-margin-50-mobile-min">
                    <span class="AlertIssueTitle">Attach Screenshot <span class="u--light-text">(Optional)</span></span>
                    <input class="AlertFormIssueCol__screenshot-input" type="file" id="fileAttach" name="attachment">
                </div>
            </div>
            <div class="AlertFormContactCol">
                <div class="AlertFormContactCol__user-info u--bottom-margin-50-mobile-min clearfix">
                    <span class="AlertIssueTitle u--bottom-margin-25-mobile-min">Who should we contact about this?</span>
                    <div class="AlertFormIssueCol__user-info-wrapper clearfix">
                        <label class="AlertFormContactCol__user-info-label" for="userName">Name</label>
                        <input class="AlertFormContactCol__user-info-input" type="text" id="userName"
                               name="contact_name"
                               data-required="true">
                    </div>
                    <div class="AlertFormIssueCol__user-info-wrapper clearfix">
                        <label class="AlertFormContactCol__user-info-label" for="userEmail">Email</label>
                        <input class="AlertFormContactCol__user-info-input" type="email" id="userEmail"
                               name="contact_email">
                    </div>
                    <div class="AlertFormIssueCol__user-info-wrapper clearfix">
                        <label class="AlertFormContactCol__user-info-label" for="userPhone">Phone</label>
                        <input class="AlertFormContactCol__user-info-input" type="tel" id="userPhone"
                               name="contact_phone">
                    </div>
                </div>
                <div class="AlertFormContactCol__additional-info">
                    <label for="anything-else" class="AlertIssueTitle">Is there anything else we should know?</label>
                <textarea class="AlertFormContactCol__additional-info-textarea" id="anything-else"
                          name="additiona_info"></textarea>
                </div>
                <input type="submit" data-toggle-text="Sending..." class="PriorityAlertForm__submit-button js--Alert-Submit-Button" value="Send Alert">
            </div>
        </form>
    </section>
    <!-- END OF: 'PriorityAlertForm' -->
</div>



