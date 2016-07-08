<form action="{{route('alerts.store')}}" method="post" id="js--Dashboard-Alert-Form" enctype="multipart/form-data">
    {{csrf_field()}}
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
                    <input type="text" id="userBrowser" name="user_browser_ver" placeholder="Browser Version">
                </li>
            </ul>
            <button class="detectUserSettings">Detect for me</button>

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
        <input type="hidden" name="client_id" value="1"/>
        <button type="submit">Submit</button>
</form>