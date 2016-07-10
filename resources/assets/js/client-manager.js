(function (window, document) {

    var AdminDashboard = function (element_id) {
        this.client_id = element_id.replace('js--Client-Dashboard_', '');
        new ClientDashboard({
            wrapper: element_id
        });
        this.$wrapper = $('#' + element_id);
        this.__initializeObjects();
        //this.__updateHoursInput();
       // this.__attachEventListeners();

    };

    AdminDashboard.prototype = {
        __preventDefaults: function () {
            $('button', this.$wrapper).on('click', function (e) {
                e.preventDefault();
            });
        },
        __attachEventListeners: function () {
            var self = this;
            this.__preventDefaults();
            function logBackupButton() {
                self.log_backup_button.on('click', function (e) {
                    e.preventDefault();
                    self.__logBackup()
                });
            }

            function planEditButton() {
                self.plan_edit_button.on('click', function () {
                    self.__togglePlanButtons();
                    self.plan_inputs.each(function (el) {
                        $(this).removeAttr('disabled');
                    });
                });
            }

            function planEditCancelButton() {
                self.plan_update_cancel_button.on('click', function () {
                    self.plan_inputs.each(function (el) {
                        var $el = $(this);
                        $el.val($el.data('original'));
                        $el.attr('disabled', true);
                    });
                    self.__togglePlanButtons();
                });
            }

            function planEditUpdateButton() {
                self.plan_update_save_button.on('click', function () {
                    if (confirm('Are you sure?  This will reset all usage stastics and start the client over with a new plan.')) {
                        self.__togglePlanButtons();
                    }
                });
            }

            function monthInputs() {
                self.month_input.on('change', function () {
                    self.__updateHoursInput();

                });
            }


            function monthlyServiceSave() {
                self.monthly_service_save_button.on('click', function () {
                    console.log('saving monthly service for month ' + self.month_input.val());
                });
            }

            function monthlyBenefitDelete() {
                self.monthly_service_benefit_deletes.on('click', function () {

                    var benefit = $(this).closest('.js--Monthly-Service-Benefit'),
                        benefit_id = benefit.data('benefit-id');
                    if (confirm('Are you sure?  This cannot be undone.')) {
                        console.log('Deleteing benefit_' + benefit_id);
                    }
                });
            }

            function monthlyBenefitEdit() {
                self.monthly_service_benefit_edits.on('click', function () {
                    var button = this;
                    if (!button.editor) {
                        button.editor = new MonthlyServiceEditor($(button));
                    }
                    else {
                        button.editor.re_init();
                    }
                });
            }
            /* Events Moved to Angular
            ===========================================================================
            logBackupButton();

            planEditButton();
            =========================================================================== */

            planEditCancelButton();
            planEditUpdateButton();

            monthlyBenefitDelete();

            monthlyServiceSave();
            monthlyBenefitEdit();
            monthInputs();


        },
        __togglePlanButtons: function () {
            this.edit_wrap.toggle();
            this.update_wrap.toggle();
        },
        __initializeObjects: function () {
            var self = this;
            var objects = {
                'month_input': '.js--Service-Month-Selection',
                'hour_usage_input': '.js--Hours-Spent-Input',
                'plan_edit_button': '.js--Monthly-Plan-edit button',
                'plan_update_save_button': '.js--Monthly-Plan-save',
                'plan_update_cancel_button': '.js--Monthly-Plan-cancel',
                'log_backup_button': '.js--Log-Backup-Button',
                'edit_wrap': '.js--Monthly-Plan-edit',
                'update_wrap': '.js--Monthly-Plan-update',
                'work_log_input': '.js--Work-Log-Input',
                'monthly_service_save_button': '.js--Monthly-Service-Log-Save',
                'plan_details_wrap': '.js--Plan-Details-Wrap',
                'monthly_service_items': '.js--Monthly-Service-Benefit',
                'monthly_service_benefit_deletes': '.js--Monthly-Service-Benefit-Delete',
                'monthly_service_benefit_edits': '.js--Monthly-Service-Benefit-Edit'
            };
            for (var i in objects) {
                self[i] = self.$wrapper.find(objects[i]);
            }
            self.plan_inputs = self.plan_details_wrap.find('input,select');
            function __recordOriginalInputValues() {
                self.plan_inputs.each(function () {
                    $(this).data('original', $(this).val());
                });
            }


            __recordOriginalInputValues();
        },
        __attachEventListeners_old: function () {
            var self = this;
            var $el = self.$wrapper,
                $logButton = $el.find('.js--Log-Backup-Button'),
                $plan_edit_button = $el.find('.js--Monthly-Plan-edit button'),
                $plan_update_save_button = $el.find('.js--Monthly-Plan-save'),
                $plan_update_cancel_button = $el.find('.js--Monthly-Plan-cancel'),
                plan_details_wrap = $el.find('.js--Plan-Details-Wrap'),
                plan_inputs = $('input,select', plan_details_wrap),
                edit_wrap = $el.find('.js--Monthly-Plan-edit'),
                update_wrap = $el.find('.js--Monthly-Plan-update')
                ;


            var month_select_input = self.$wrapper.find('.js--Service-Month-Selection');
            month_select_input.on('change', function () {
                self.__updateHoursInput();
            });

        },
        __initializeMonthSelection: function () {


            this.__updateHoursInput();
        },
        __updateHoursInput: function () {


            var selected_option = this.month_input.find('option:selected');
            //console.log(selected_option);
            this.hour_usage_input.val(selected_option.data('usage'));
            this.work_log_input.val(selected_option.data('description'));
        },
        __logBackup: function () {
            console.log("logging backup for " + this.client_id);
        },
    };


    var ClientManager = function (wrapper) {
        this.wrapper = wrapper;
        var dashboards = $(wrapper).find('.RT-Client_Dashboard');
        this.dashboard_objects = [];

        for (var i = 0; i < dashboards.length; i++) {
            this.dashboard_objects.push(new AdminDashboard(dashboards[i].id));
        }
    };
    ClientManager.prototype = {};
    window.ClientManager = ClientManager;

    var MonthlyServiceEditor = function (button) {
        this.has_run = false;
        var editor = this;
        this.button_parent = button.parent();
        var benefit = button.closest('.js--Monthly-Service-Benefit');
        this.benefit = benefit;
        var $cancel_update = $('<button class="btn btn-danger btn-block">Cancel</button>');
        var $save_update = $('<button class="btn btn-danger btn-block">Save</button>');
        this.$new_buttons = $([$cancel_update[0], $save_update[0]]);
        this.$original_buttons = this.button_parent.children();
        this.$original_buttons.hide();
        this.button_parent.append($cancel_update);
        this.button_parent.append($save_update);
        this.init();
        this.swapElements();
        $cancel_update.on('click', function (e) {
            e.preventDefault();
            editor.__reset();
        });
        $save_update.on('click', function (e) {
            e.preventDefault();
            console.log('saving updated benefit');
        })
    };


    MonthlyServiceEditor.prototype = {
        re_init: function () {
            this.swapElements();
            this.$original_buttons.hide();
            this.$new_buttons.show();
        },
        __restore_inputs: function () {
            for (var i = 0; i < this.objs.length; i++) {
                parent = this.backup[this.objs[i]].el.parent();
                console.log(parent);
                var newEl;
                if (this.objs[i] != 'image') {
                    this['$' + this.objs[i] + '_input'].hide();
                    this[this.objs[i]].el.show();
                }

                else {

                    this[this.objs[i]].el[0].style.opacity = 1;
                    $(this.file_input).hide();

                }
                this.has_run = true;
                parent.prepend(newEl);
            }
        },
        __reset: function () {
            this.$new_buttons.hide();
            this.$original_buttons.show();
            this.__restore_inputs();
        },
        swapElements: function () {
            this.backup = jQuery.extend(true, {}, this);
            for (var i = 0; i < this.objs.length; i++) {
                parent = this[this.objs[i]].el.parent();

                var newEl;
                if (this.objs[i] == 'heading') {
                    this[this.objs[i]].el.hide();
                    this.$heading_input = $('<input type="text" class="form-control">').val(this.heading.value);
                    newEl = this.$heading_input;
                }
                else if (this.objs[i] == 'description') {
                    this[this.objs[i]].el.hide();
                    this.$description_input = $('<textarea class="form-control"></textarea>').html(this.description.value);
                    newEl = this.$description_input;
                }
                else if (this.objs[i] == 'image') {

                    this[this.objs[i]].el[0].style.opacity = .5;
                    if (!this.has_run) {
                        newEl = $('<input type="file" class="form-control">');//.html(this.heading.value);
                        this.file_input = newEl;
                    }
                    else {
                        this.file_input.show();
                    }
                }
                this.has_run = true;
                parent.prepend(newEl);
            }


            //var parent = this.heading.el[0].parentNode;
            // console.log(this.heading.el[0]);
            // var newChild = parent.querySelector('js--Monthly-Service-Benefit__heading');
            // console.log(newChild);
            //
            //
            // parent.replaceChild(newChild,h);

        },
        init: function () {
            var editor = this;
            this.objs = ['image', 'description', 'heading']; //order is important
            var objs = this.objs;
            for (var i = 0; i < objs.length; i++) {
                var selector = '.js--Monthly-Service-Benefit__' + objs[i];
                editor[objs[i]] = $(selector, editor.benefit);
                editor[objs[i]].el = $('.js--Monthly-Service-Benefit__' + objs[i], editor.benefit);
                if (objs[i] == 'image') {
                    editor[objs[i]].value = editor[objs[i]].el.attr('src');
                }
                else {
                    editor[objs[i]].value = editor[objs[i]].el.html();
                }
            }
        }
    };


}(window, document));