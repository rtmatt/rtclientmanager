<section>
    <div class="Monthly-Service js--Monthly-Service-Benefit"
         ng-repeat="benefit in benefitsController.benefits">
        <div class="row" ng-controller="benefitEditorController as benefitEdit">
            <div class="col-sm-3">
                <img ng-src="@{{ benefit.icon }}"
                     class="img-responsive js--Monthly-Service-Benefit__image" ng-hide="benefitEdit.editMode"
                     alt=""/>
                <div class="form-group" ng-show="benefitEdit.editMode">
                    <button class="btn btn-primary" type="button" id="file_upload_btn" ngf-select ng-model="benefit.file" name="file" ngf-pattern="'image/*,application/pdf,application/zip,application/x-rar-compressed'"
                            accept="image/*,application/pdf,application/zip,application/x-rar-compressed" ngf-max-size="10MB"  ng-required="file.description && !file.id">Choose File</button>
                    <span ng-show="benefit.file.name || !file.id">@{{benefit.file.name || 'None Selected'}}</span>
                </div>
            </div>
            <div class="col-sm-7">
                <h3 ng-hide="benefitEdit.editMode"
                    class="js--Monthly-Service-Benefit__heading">@{{ benefit.name }}</h3>
                <div class="form-group" ng-show="benefitEdit.editMode">
                    <input type="text" ng-model="benefit.name">
                </div>
                <p ng-hide="benefitEdit.editMode"
                   class="js--Monthly-Service-Benefit__description">@{{ benefit.description }}
                </p>
                    <textarea name="" ng-show="benefitEdit.editMode" id="" cols="30" rows="10"
                              ng-model="benefit.description"></textarea>
            </div>
            <div class="col-sm-2">
                <div ng-hide="benefitEdit.editMode">
                    <button type="button" ng-click="benefitEdit.delete()"
                            class="btn btn-danger btn-block js--Monthly-Service-Benefit-Delete">
                        Delete
                    </button>
                    <button type="button" ng-click="benefitEdit.edit()"
                            class="btm btn-info btn-block js--Monthly-Service-Benefit-Edit">Edit
                    </button>
                </div>
                <div ng-show="benefitEdit.editMode">
                    <button type="button" ng-click="benefitEdit.save()"
                            class="btn btn-danger btn-block js--Monthly-Service-Benefit-Delete">
                        Save
                    </button>
                    <button type="button" ng-click="benefitEdit.cancel()"
                            class="btm btn-info btn-block js--Monthly-Service-Benefit-Edit">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div ng-show="benefitsController.addMode" class="clearfix">
        <hr/>
        <h2>Add Monthly Service</h2>
        <div class="row" ng-repeat="new_benefit in benefitsController.new_benefits track by $index">
            <div class="col-sm-3">
                <div class="form-group">
                    {{--@todo: implement correctly--}}
                    <button class="btn btn-primary" type="button" ngf-select ng-model="new_benefit.file" name="file" ngf-pattern="'image/*,application/pdf,application/zip,application/x-rar-compressed'"
                            accept="image/*,application/pdf,application/zip,application/x-rar-compressed" ngf-max-size="10MB"  ng-required="file.description && !file.id">Choose File</button>
                    <span ng-show="new_benefit.file.name || !file.id">@{{new_benefit.file.name || 'None Selected'}}</span>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="form-group">
                    <label for="">Name</label>
                    <input class="form-control" type="text" ng-model="new_benefit.name">
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                    <textarea class="form-control" ng-model="new_benefit.description"></textarea>
                </div>
            </div>
            <div class="col-sm-2" ng-if="!benefitsController.batch_edit">
                <button type="button" class="btm btn-info btn-block" ng-click="benefitsController.saveNewBenefitByIndex($index)">Save</button>
                <button type="button" class="btm btn-info btn-block" ng-click="benefitsController.cancelNewBenefit($index)">Cancel</button>
            </div>
        </div>
    </div>

    <div class="clearfix text-center" ng-hide="benefitsController.addMode && !benefitsController.batch_edit">
        <button style="display:block;margin:30px auto;" ng-click="benefitsController.addBenefit()" type="button"
                class="btn btn-primary">Add Monthly Service &plus;</button>
    </div>
</section>