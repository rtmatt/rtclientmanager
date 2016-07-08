(function (window, document) {
    var ClientDashboard = function (options) {
        this.options = jQuery.extend(this.options, options);
        if (!this.__dependenciesLoaded()) {
            return;
        }
        if (!this.__initializeObjects(options)) {
            return;
        }
        this.__init();
    };
//TODO: We need to update all the stuff for the admin manager.  Updating/reanimating months
    // when data changes
    ClientDashboard.prototype = {
        __dependenciesLoaded: function () {
            if (typeof Circles !== 'function') {
                console.log("Circles is not loaded.  Exiting.");
                return false;
            }

            if (typeof jQuery === 'undefined') {
                console.log("jQuery is necessary.  Exiting.");
                return false;
            }
            return true;
        },
        __initializeTopLevelObjects: function () {
            for (var k = 0; k < this.topLevelObjects.length; k++) {
                var key = this.topLevelObjects[k];
                if (key == "wrapper") {
                    this[key] = document.getElementById(this.options[key]);
                }
                else {
                    this[key] = this.wrapper.querySelector('.' + this.options[key]);
                }
            }

        },
        __initializeDependentObjects: function () {
            this.toggleIcon = this.alertToggle.querySelector('.js--PriorityAlert-Toggle__icon');
            this.toggleText = this.alertToggle.querySelector('.js--PriorityAlert-Toggle__text');
        },
        __allNecessaryObjectsLoaded: function () {
            for (var i = 0; i < this.necessaryObjects.length; i++) {
                if (!this[this.necessaryObjects[i]]) {
                    console.log("Invalid " + this.necessaryObjects[i] + " provided.  Exiting.");
                    return false;
                }
            }
            return true;
        },
        __initializeObjects: function (options) {
            this.__initializeTopLevelObjects();
            this.__initializeDependentObjects();
            return this.__allNecessaryObjectsLoaded();
        },
        __getGraphRadius: function () {
            var graph = $()
        },
        __responsiveMonths: function () {
            for (var i = 0; i < this.months.length; i++) {

                var month_width = this.months[i].querySelector('.js--graph').offsetWidth;
                this.graphs[i].updateWidth(month_width / 5.25);
                this.graphs[i].updateRadius(month_width / 2);

            }
        },
        __initMonths: function () {
            var self = this;
            this.months = this.wrapper.querySelectorAll('.month');
            this.graphs = [];
            for (var i = 0; i < this.months.length; i++) {
                var month = this.months[i];
                var graph_wrap = month.querySelector('.js--graph');

                var percent_ratio = month.dataset.percent_used / 100;


                this.graphs[i] = Circles.create({
                    id: 'js--circle-' + i,
                    radius: graph_wrap.offsetWidth / 2,
                    //  value: month.dataset.hours_used,
                    maxValue: month.dataset.hours_available,
                    width: graph_wrap.offsetWidth / 5.25,
                    text: month.dataset.hours_used,
                    colors: ['#DFDFDF', '#8dd624'],
                    duration: 400,
                    wrpClass: 'circles-wrp',
                    textClass: 'progressbar-text',
                    styleWrapper: true,
                    styleText: true
                });

            }
            // Listen for window resize to stop.  When it does, update the widths and the radius
            // for the graphs
            function monthResizeListener() {
                var resizetimeout;
                window.onresize = function () {
                    clearTimeout(resizetimeout);
                    resizetimeout = setTimeout(function () {
                        self.__responsiveMonths();

                    }, 250);

                }
            }

            monthResizeListener();

        },
        drawGraphs: function () {
            this.drawMonths();
            var self = this;
            window.setTimeout(function () {
                self.drawAnnual();
            }, 300)
        },
        updateAnnual: function (change) {
            this.annual_hours_used = parseFloat(this.annual_hours_used) + parseFloat(change);
            this.annual_value_element.innerText = this.annual_hours_used;
            this.drawAnnual();

        },
        reset: function (data) {
            this.annual_hours_used = 0;
            this.annual_hours_available = data.hours_available_year;
            this.annual_value_element.innerText = "0";
            this.annual_value_element.style.left = 0;
            this.annual_progress.style.width = 0;
            this.annual_value_element.style.color = 'inherit';
            this.annual_progress.style.backgroundColor = "#8dd624";
            this.annual_value_element.style.marginLeft = '0';
            var annual_avail_el = this.wrapper.querySelector('.js--AnnualHoursAvailable');
            annual_avail_el.innerText = data.hours_available_year;

            for (var i = 0; i < this.months.length; i++) {
                //Update Month Name
                var month_el = this.months[i],
                    month_el_name = month_el.querySelector('.js--Month-Name');

                if (month_el.classList.contains('HourSphere--currentMonth')) {
                    month_el.classList.remove('HourSphere--currentMonth');
                }


                var date_obj = new Date(data.service_history.months[i].name);

                var date_text = date_obj.toLocaleString('en-us', {month: "short"});
                month_el_name.innerText = date_text;
                if (date_obj.toLocaleString('en-us', {
                        month: "short",
                        year: "numeric"
                    }) == new Date().toLocaleString('en-us', {month: "short", year: "numeric"})) {
                    month_el.classList.add('HourSphere--currentMonth');
                }
                //Highlight Current Month


                //Recreate Graph
                this.graphs[i].destroy();
                this.graphs[i] = new ProgressBar.Circle(this.months[i], {
                    color: '#8dd624',
                    text: {
                        value: "-"
                    }
                });
            }
        },
        drawAnnual: function () {
            this.annual_percent_usage = this.annual_hours_used / this.annual_hours_available * 100;
            if (this.annual_percent_usage > 100) {
                this.annual_percent_usage = 105;
                this.annual_value_element.style.color = 'red';
                this.annual_progress.style.backgroundColor = "red";
            }
            this.annual_progress.style.width = this.annual_percent_usage + "%";
            this.annual_value_element.style.left = this.annual_percent_usage + "%";
            if (this.annual_percent_usage > 94) {
                this.annual_value_element.style.marginLeft = '-22px';
            }
            else if (this.annual_percent_usage > 50) {
                this.annual_value_element.style.marginLeft = '-15px';
            }


        },
        drawMonths: function () {
            if (!this.hasOwnProperty('months') || !this.hasOwnProperty('graphs')) {
                return;
            }
            for (var i = 0; i < this.months.length; i++) {
                var data = this.months[i].dataset.percent_used / 100;
                // this.drawMonth(i, data);
                this.drawMonthWithCircles(i)
            }
        },
        // DRAW A MONTH USING CIRCLES.JS
        // USING DATA FROM THE Months Member dataset, draw the circle.  That's it
        drawMonthWithCircles: function (index) {
            this.graphs[index].update(this.months[index].dataset.hours_used);
        },
        // THIS DRAWS A MONTH USING THE NOW-DEPRECATED PROGRESSBAR.JS
        drawMonth: function (month_index, data, value) {
            //IF OVER LIMIT
            if (data > 1) {
                data = 1;
                this.graphs[month_index].destroy();
                this.graphs[month_index] = new ProgressBar.Circle(this.months[month_index], {
                    color: '#ff0000',
                    from: {color: '#8dd624'},
                    to: {color: '#ff0000'},
                    text: {
                        value: value ? value : this.months[month_index].dataset.hours_used
                    }

                });
                this.graphs[month_index].animate(data);
                this.graphs[month_index].overage = true;
                return;
            }

            if (this.graphs[month_index].overage == true) {
                this.graphs[month_index].destroy();
                this.graphs[month_index] = new ProgressBar.Circle(this.months[month_index], {
                    color: '#8dd624',
                    to: {color: '#8dd624'},
                    from: {color: '#ff0000'},
                    text: {
                        value: value ? value : this.months[month_index].dataset.hours_used
                    }

                });
                this.graphs[month_index].animate(data);
                this.graphs[month_index].overage = false;
                return;
            }
            this.graphs[month_index].animate(data);


        },
        __initAnnual: function () {
            //@todo: optimize this maybe

            this.annual_wrap = this.wrapper.querySelector('.js--annual_usage'),
                this.annual_percent_usage = this.annual_wrap.dataset.year_percent_used,
                this.annual_progress = this.wrapper.querySelector('.js--Dashboard__annual-usage-progress'),
                this.annual_value_element = this.wrapper.querySelector('.js--Dashboard__annual-usage-value');
            this.annual_hours_available = this.annual_wrap.dataset.year_hours_available;
            this.annual_hours_used = this.annual_wrap.dataset.year_hours_used;


        },
        __toggleForm: function () {
            var $alertForm = $(this.alertForm);
            $alertForm.slideToggle("fast");
        },
        __toggleAlertIcon: function () {
            var currentIcon = this.toggleIcon.getAttribute('src');
            var altIcon = this.toggleIcon.dataset.altSrc;
            this.toggleIcon.dataset.altSrc = currentIcon;
            this.toggleIcon.setAttribute('src', altIcon);
        },
        __toggleAlertText: function () {

            var currentText = this.toggleText.innerHTML;
            this.toggleText.innerHTML = this.toggleText.dataset.toggleTemplate;
            this.toggleText.dataset.toggleTemplate = currentText;
        },
        __handleResponse: function (messages, s, wrapper) {
            var alert = document.createElement('div');
            alert.classList.add(s);
            alert.classList.add('alert');
            var alert_list = document.createElement('ul');
            alert_list.classList.add('alert__list');
            for (var i = 0; i < messages.length; i++) {
                var node = document.createElement('li');
                node.innerHTML = messages[i];
                alert_list.appendChild(node);
            }

            alert.appendChild(alert_list);
            wrapper.insertBefore(alert, wrapper.firstChild);
            this.alertBlock = alert;
            $('html,body').animate({
                scrollTop:$(wrapper).offset().top
            },200);


        },
        __toggleAlertForm: function ($alertToggle) {
            var self = this;
            $(self.alertToggle).toggleClass("alertFormActive");

            if (self.alertBlock !== undefined) {
                self.alertBlock.parentNode.removeChild(self.alertBlock);
                delete self.alertBlock;
            }
            self.__toggleAlertText();
            self.__toggleAlertIcon();
            self.__toggleForm();
        },
        __attachListeners: function () {
            var self = this;

            function __attachToggleListener() {
                $(self.alertToggle).click(function () {
                    self.__toggleAlertForm();
                });
            }

            function __attachModalListener() {
                $(self.modalTrigger).on('click', function () {
                    $(self.modal).modal();
                });
            }

            function __toggleSubmitButton() {
                var button = self.alertSubmitButton;
                button.disabled = !button.disabled;
                var value = button.value;
                button.value = button.dataset.toggleText;
                button.dataset.toggleText = value;
            }

            function __resetForm(validator) {
                var inputs = self.alertFormForm.querySelectorAll('input,textarea');
                for (var i = 0; i < inputs.length; i++) {
                    var input = inputs[i];
                    if (input.classList.contains(self.options.alertSubmitButton)) {
                        continue;
                    }
                    input.value = '';
                    if (input.checked) {
                        input.checked = false;
                    }
                }
                var fields = $(self.alertFormForm).parsley().fields;
                $(self.alertFormForm).parsley().reset();
            }

            function __attachFormListener() {
                var $alertForm = $(self.alertFormForm);//,
                formValidator = $alertForm.parsley();
                $alertForm.on('submit', function (e) {
                    e.preventDefault();
                    if (self.alertBlock !== undefined) {
                        self.alertBlock.parentNode.removeChild(self.alertBlock);
                    }
                    var data = new FormData(self.alertFormForm);

                    function __handleErrors(jqXHR) {
                        json = jqXHR.responseJSON;
                        var errors = [];
                        for (var i in json) {
                            if (json.hasOwnProperty(i)) {
                                errors.push(json[i]);
                            }
                        }
                        self.__handleResponse(errors, 'error', self.alertForm);
                    }

                    if (formValidator.isValid()) {
                        __toggleSubmitButton();
                        //todo: disable submit button and display user feedback the form is working
                        $.ajax({
                            type: 'POST',
                            url: '/api/client-service/priority-alert',
                            data: data,
                            contentType: false,
                            processData: false,
                            headers: {
                                "Authorization": 'Basic ' + self.options.auth
                            },
                            success: function (data) {
                                //self.__toggleAlertForm();
                                self.__handleResponse(['We received your message and will respond soon.'], 'success', self.alertForm);
                                //todo: clear form inputs, clear errors, undisable submit button.
                                __resetForm();
                                __toggleSubmitButton();
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                if (errorThrown == "Unprocessable Entity") {
                                    return __handleErrors(jqXHR);
                                }
                                return self.__handleResponse(['There was an error on our end. Please send us an email.'], 'error', self.alertForm);
                            }
                        });
                    }

                });
            }


            __attachToggleListener();


            __attachModalListener();
            __attachFormListener();

        },
        updateMonth: function (month_index, percent, value) {
            var monthNode = this.months[month_index];
            monthNode.dataset.percent_used = percent;
            var text_display = monthNode.querySelector('.progressbar-text');
            text_display.innerText = value;
            this.drawMonth(month_index, percent / 100, value);
        },

        __init: function () {
            this.__initMonths();

            this.__initAnnual();
            this.__attachListeners();
            if (this.options.delay !== true) {
                this.drawGraphs();
            }
        },
        options: {
            wrapper: 'js--Client-Dashboard',
            alertToggle: 'js--Dashboard__alert-toggle',
            alertForm: 'js--Dashboard__alert-form',
            alertFormForm: 'js--Dashboard-Alert-Form',
            alertSubmitButton: 'js--Alert-Submit-Button',
            modalTrigger: 'js--Modal-Trigger',
            modal: 'js--Modal',

            delay: false
        },
        topLevelObjects: [
            'wrapper', 'alertToggle', 'alertForm', 'alertFormForm', 'modalTrigger', 'modal', 'alertSubmitButton'
        ],
        necessaryObjects: [
            'wrapper', 'alertForm', 'alertToggle', 'toggleIcon', 'toggleText', 'modalTrigger', 'modal'
        ]
    };
    window.ClientDashboard = ClientDashboard;
}(window, document));