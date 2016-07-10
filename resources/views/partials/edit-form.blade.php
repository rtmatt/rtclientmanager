<form action="" class="js--Dashboard-Admin-Form">
    <fieldset class="row js--Plan-Details-Wrap"
              ng-controller="clientDashboardPlanEditController as planEdit">
        <div class="col-sm-3">
            <div class="form-group" style="position:relative;"
                 ng-class="{'has-error':(clientAddForm.date.$error.required || clientAddForm.date.$error.moment) && clientAdd.submitted}">
                <label class="RT-Dashboard-Form__label" for="">Start Month</label>
                <input name="date" required monthpicker moment class="form-control" type="text"
                       ng-disabled="!planEdit.editMode"
                       ng-change="planEdit.selectMonth(planEdit.formData.active_month.name)"
                       name="formData.activeMonth"
                       ng-model="planEdit.formData.active_month.name">
            </div>
        </div>
        <div class="col-sm-7">
            <div class="row">
                <div class="col-sm-4">
                    <label class="RT-Dashboard-Form__label" for="">Annual Hours</label>
                    <input class="form-control js--Plan-Edit-Input" ng-model="planEdit.formData.hours_available_year"
                           type="text"
                           ng-disabled="!planEdit.editMode">
                </div>
                <div class="col-sm-4">
                    <label class="RT-Dashboard-Form__label" for="">Monthly Hours</label>
                    <input class="form-control js--Plan-Edit-Input" ng-model="planEdit.formData.hours_available_month"
                           type="text"
                           ng-disabled="!planEdit.editMode">
                </div>
                <div class="col-sm-4">
                    <label class="RT-Dashboard-Form__label" for="">Standard Rate</label>
                    <input class="form-control js--Plan-Edit-Input" ng-model="planEdit.formData.standard_rate"
                           type="text"
                           ng-disabled="!planEdit.editMode">
                </div>
            </div>
        </div>
        <div class="col-sm-2 js--Plan-Edit-Buttons-Wrap">
            <label class="RT-Dashboard-Form__label" for="">&nbsp;</label>
            <div class="js--Monthly-Plan-edit">
                <button type="button" class="RT-Dashboard-Form__button js--Plan-Edit-Button"
                        ng-click="planEdit.edit()"
                        ng-hide="planEdit.editMode">Edit
                </button>
                <button type="button" class="RT-Dashboard-Form__button js--Monthly-Plan-save js--Plan-Edit-Button"
                        ng-click="planEdit.save()"
                        ng-hide=" !planEdit.editMode ">Save
                </button>
                <button type="button" class="RT-Dashboard-Form__button js--Monthly-Plan-cancel js--Plan-Edit-Button"
                        ng-click="planEdit.cancel()"
                        ng-hide=" !planEdit.editMode ">Cancel
                </button>
            </div>
        </div>
    </fieldset>
    <hr/>
    <fieldset class="row js--Month-Information-Wrap" ng-controller="clientDashboardPlanLogController as log">
        <div class="col-sm-3">
            <label class="RT-Dashboard-Form__label u--margin-top-0" for="">Select Month</label>
            <select name="" id="" class="form-control js--Plan-Edit-Input"
                    ng-options="month.name for month in log.serviceMonths track by month.id"
                    ng-model="log.formData.active_month"
                    ng-change="log.changeActive()">
            </select>
            <div class="form-group">
                <label for="" class="u--margin-top-0">Hours Spent</label>
                <input type="text" ng-model="log.formData.active_month.hours_logged"
                       class="form-control js--Hours-Spent-Input"
                       ng-change="log.resetButton()"/>
            </div>
        </div>
        <div class="form-group col-sm-7">
            <label class="RT-Dashboard-Form__label u--margin-top-0" for="">Description of Work Done</label>
            <textarea ng-change="log.resetButton()" class="js--Work-Log-Input" name=""
                      ng-model="log.formData.active_month.description" id="" cols="30"
                      rows="10"></textarea>
        </div>
        <div class="col-sm-2">
            <label class="RT-Dashboard-Form__label" for="">&nbsp;</label>
            <button type="button" ng-click="log.saveLog()"
                    class="RT-Dashboard-Form__button js--Monthly-Service-Log-Save">@{{ log.buttonText }}</button>
        </div>
    </fieldset>
    {{--<hr/>--}}
    <benefits></benefits>

</form>