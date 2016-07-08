/*!
 * Parsley.js
 * Version 2.4.3 - built Sat, Jun 18th 2016, 9:01 pm
 * http://parsleyjs.org
 * Guillaume Potier - <guillaume@wisembly.com>
 * Marc-Andre Lafortune - <petroselinum@marc-andre.ca>
 * MIT Licensed
 */
function _toConsumableArray(e){if(Array.isArray(e)){for(var t=0,i=Array(e.length);t<e.length;t++)i[t]=e[t];return i}return Array.from(e)}var _slice=Array.prototype.slice;!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t(require("jquery")):"function"==typeof define&&define.amd?define(["jquery"],t):e.parsley=t(e.jQuery)}(this,function(e){"use strict";function t(e,t){return e.parsleyAdaptedCallback||(e.parsleyAdaptedCallback=function(){var i=Array.prototype.slice.call(arguments,0);i.unshift(this),e.apply(t||R,i)}),e.parsleyAdaptedCallback}function i(e){return 0===e.lastIndexOf(q,0)?e.substr(q.length):e}/**
 * inputevent - Alleviate browser bugs for input events
 * https://github.com/marcandre/inputevent
 * @version v0.0.3 - (built Thu, Apr 14th 2016, 5:58 pm)
 * @author Marc-Andre Lafortune <github@marc-andre.ca>
 * @license MIT
 */
function n(){var t=this,i=window||global;e.extend(this,{isNativeEvent:function(e){return e.originalEvent&&e.originalEvent.isTrusted!==!1},fakeInputEvent:function(i){t.isNativeEvent(i)&&e(i.target).trigger("input")},misbehaves:function(i){t.isNativeEvent(i)&&(t.behavesOk(i),e(document).on("change.inputevent",i.data.selector,t.fakeInputEvent),t.fakeInputEvent(i))},behavesOk:function(i){t.isNativeEvent(i)&&e(document).off("input.inputevent",i.data.selector,t.behavesOk).off("change.inputevent",i.data.selector,t.misbehaves)},install:function(){if(!i.inputEventPatched){i.inputEventPatched="0.0.3";for(var n=["select",'input[type="checkbox"]','input[type="radio"]','input[type="file"]'],r=0;r<n.length;r++){var s=n[r];e(document).on("input.inputevent",s,{selector:s},t.behavesOk).on("change.inputevent",s,{selector:s},t.misbehaves)}}},uninstall:function(){delete i.inputEventPatched,e(document).off(".inputevent")}})}var r=1,s={},a={attr:function(e,t,i){var n,r,s,a=new RegExp("^"+t,"i");if("undefined"==typeof i)i={};else for(n in i)i.hasOwnProperty(n)&&delete i[n];if("undefined"==typeof e||"undefined"==typeof e[0])return i;for(s=e[0].attributes,n=s.length;n--;)r=s[n],r&&r.specified&&a.test(r.name)&&(i[this.camelize(r.name.slice(t.length))]=this.deserializeValue(r.value));return i},checkAttr:function(e,t,i){return e.is("["+t+i+"]")},setAttr:function(e,t,i,n){e[0].setAttribute(this.dasherize(t+i),String(n))},generateID:function(){return""+r++},deserializeValue:function(t){var i;try{return t?"true"==t||("false"==t?!1:"null"==t?null:isNaN(i=Number(t))?/^[\[\{]/.test(t)?e.parseJSON(t):t:i):t}catch(n){return t}},camelize:function(e){return e.replace(/-+(.)?/g,function(e,t){return t?t.toUpperCase():""})},dasherize:function(e){return e.replace(/::/g,"/").replace(/([A-Z]+)([A-Z][a-z])/g,"$1_$2").replace(/([a-z\d])([A-Z])/g,"$1_$2").replace(/_/g,"-").toLowerCase()},warn:function(){var e;window.console&&"function"==typeof window.console.warn&&(e=window.console).warn.apply(e,arguments)},warnOnce:function(e){s[e]||(s[e]=!0,this.warn.apply(this,arguments))},_resetWarnings:function(){s={}},trimString:function(e){return e.replace(/^\s+|\s+$/g,"")},namespaceEvents:function(t,i){return t=this.trimString(t||"").split(/\s+/),t[0]?e.map(t,function(e){return e+"."+i}).join(" "):""},difference:function(t,i){var n=[];return e.each(t,function(e,t){-1==i.indexOf(t)&&n.push(t)}),n},all:function(t){return e.when.apply(e,_toConsumableArray(t).concat([42,42]))},objectCreate:Object.create||function(){var e=function(){};return function(t){if(arguments.length>1)throw Error("Second argument not supported");if("object"!=typeof t)throw TypeError("Argument must be an object");e.prototype=t;var i=new e;return e.prototype=null,i}}()},o=a,l={namespace:"data-parsley-",inputs:"input, textarea, select",excluded:"input[type=button], input[type=submit], input[type=reset], input[type=hidden]",priorityEnabled:!0,multiple:null,group:null,uiEnabled:!0,validationThreshold:3,focus:"first",trigger:!1,triggerAfterFailure:"input",errorClass:"parsley-error",successClass:"parsley-success",classHandler:function(e){},errorsContainer:function(e){},errorsWrapper:'<ul class="parsley-errors-list"></ul>',errorTemplate:"<li></li>"},u=function(){this.__id__=o.generateID()};u.prototype={asyncSupport:!0,_pipeAccordingToValidationResult:function(){var t=this,i=function(){var i=e.Deferred();return!0!==t.validationResult&&i.reject(),i.resolve().promise()};return[i,i]},actualizeOptions:function(){return o.attr(this.$element,this.options.namespace,this.domOptions),this.parent&&this.parent.actualizeOptions&&this.parent.actualizeOptions(),this},_resetOptions:function(e){this.domOptions=o.objectCreate(this.parent.options),this.options=o.objectCreate(this.domOptions);for(var t in e)e.hasOwnProperty(t)&&(this.options[t]=e[t]);this.actualizeOptions()},_listeners:null,on:function(e,t){this._listeners=this._listeners||{};var i=this._listeners[e]=this._listeners[e]||[];return i.push(t),this},subscribe:function(t,i){e.listenTo(this,t.toLowerCase(),i)},off:function(e,t){var i=this._listeners&&this._listeners[e];if(i)if(t)for(var n=i.length;n--;)i[n]===t&&i.splice(n,1);else delete this._listeners[e];return this},unsubscribe:function(t,i){e.unsubscribeTo(this,t.toLowerCase())},trigger:function(e,t,i){t=t||this;var n,r=this._listeners&&this._listeners[e];if(r)for(var s=r.length;s--;)if(n=r[s].call(t,t,i),n===!1)return n;return this.parent?this.parent.trigger(e,t,i):!0},reset:function(){if("ParsleyForm"!==this.__class__)return this._resetUI(),this._trigger("reset");for(var e=0;e<this.fields.length;e++)this.fields[e].reset();this._trigger("reset")},destroy:function(){if(this._destroyUI(),"ParsleyForm"!==this.__class__)return this.$element.removeData("Parsley"),this.$element.removeData("ParsleyFieldMultiple"),void this._trigger("destroy");for(var e=0;e<this.fields.length;e++)this.fields[e].destroy();this.$element.removeData("Parsley"),this._trigger("destroy")},asyncIsValid:function(e,t){return o.warnOnce("asyncIsValid is deprecated; please use whenValid instead"),this.whenValid({group:e,force:t})},_findRelated:function(){return this.options.multiple?this.parent.$element.find("["+this.options.namespace+'multiple="'+this.options.multiple+'"]'):this.$element}};var d={string:function(e){return e},integer:function(e){if(isNaN(e))throw'Requirement is not an integer: "'+e+'"';return parseInt(e,10)},number:function(e){if(isNaN(e))throw'Requirement is not a number: "'+e+'"';return parseFloat(e)},reference:function(t){var i=e(t);if(0===i.length)throw'No such reference: "'+t+'"';return i},"boolean":function(e){return"false"!==e},object:function(e){return o.deserializeValue(e)},regexp:function(e){var t="";return/^\/.*\/(?:[gimy]*)$/.test(e)?(t=e.replace(/.*\/([gimy]*)$/,"$1"),e=e.replace(new RegExp("^/(.*?)/"+t+"$"),"$1")):e="^"+e+"$",new RegExp(e,t)}},h=function(e,t){var i=e.match(/^\s*\[(.*)\]\s*$/);if(!i)throw'Requirement is not an array: "'+e+'"';var n=i[1].split(",").map(o.trimString);if(n.length!==t)throw"Requirement has "+n.length+" values when "+t+" are needed";return n},p=function(e,t){var i=d[e||"string"];if(!i)throw'Unknown requirement specification: "'+e+'"';return i(t)},c=function(e,t,i){var n=null,r={};for(var s in e)if(s){var a=i(s);"string"==typeof a&&(a=p(e[s],a)),r[s]=a}else n=p(e[s],t);return[n,r]},f=function(t){e.extend(!0,this,t)};f.prototype={validate:function(t,i){if(this.fn)return arguments.length>3&&(i=[].slice.call(arguments,1,-1)),this.fn.call(this,t,i);if(e.isArray(t)){if(!this.validateMultiple)throw"Validator `"+this.name+"` does not handle multiple values";return this.validateMultiple.apply(this,arguments)}if(this.validateNumber)return isNaN(t)?!1:(arguments[0]=parseFloat(arguments[0]),this.validateNumber.apply(this,arguments));if(this.validateString)return this.validateString.apply(this,arguments);throw"Validator `"+this.name+"` only handles multiple values"},parseRequirements:function(t,i){if("string"!=typeof t)return e.isArray(t)?t:[t];var n=this.requirementType;if(e.isArray(n)){for(var r=h(t,n.length),s=0;s<r.length;s++)r[s]=p(n[s],r[s]);return r}return e.isPlainObject(n)?c(n,t,i):[p(n,t)]},requirementType:"string",priority:2};var m=function(e,t){this.__class__="ParsleyValidatorRegistry",this.locale="en",this.init(e||{},t||{})},g={email:/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i,number:/^-?(\d*\.)?\d+(e[-+]?\d+)?$/i,integer:/^-?\d+$/,digits:/^\d+$/,alphanum:/^\w+$/i,url:new RegExp("^(?:(?:https?|ftp)://)?(?:\\S+(?::\\S*)?@)?(?:(?:[1-9]\\d?|1\\d\\d|2[01]\\d|22[0-3])(?:\\.(?:1?\\d{1,2}|2[0-4]\\d|25[0-5])){2}(?:\\.(?:[1-9]\\d?|1\\d\\d|2[0-4]\\d|25[0-4]))|(?:(?:[a-z\\u00a1-\\uffff0-9]-*)*[a-z\\u00a1-\\uffff0-9]+)(?:\\.(?:[a-z\\u00a1-\\uffff0-9]-*)*[a-z\\u00a1-\\uffff0-9]+)*(?:\\.(?:[a-z\\u00a1-\\uffff]{2,})))(?::\\d{2,5})?(?:/\\S*)?$","i")};g.range=g.number;var v=function(e){var t=(""+e).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);return t?Math.max(0,(t[1]?t[1].length:0)-(t[2]?+t[2]:0)):0};m.prototype={init:function(t,i){this.catalog=i,this.validators=e.extend({},this.validators);for(var n in t)this.addValidator(n,t[n].fn,t[n].priority);window.Parsley.trigger("parsley:validator:init")},setLocale:function(e){if("undefined"==typeof this.catalog[e])throw new Error(e+" is not available in the catalog");return this.locale=e,this},addCatalog:function(e,t,i){return"object"==typeof t&&(this.catalog[e]=t),!0===i?this.setLocale(e):this},addMessage:function(e,t,i){return"undefined"==typeof this.catalog[e]&&(this.catalog[e]={}),this.catalog[e][t]=i,this},addMessages:function(e,t){for(var i in t)this.addMessage(e,i,t[i]);return this},addValidator:function(e,t,i){if(this.validators[e])o.warn('Validator "'+e+'" is already defined.');else if(l.hasOwnProperty(e))return void o.warn('"'+e+'" is a restricted keyword and is not a valid validator name.');return this._setValidator.apply(this,arguments)},updateValidator:function(e,t,i){return this.validators[e]?this._setValidator.apply(this,arguments):(o.warn('Validator "'+e+'" is not already defined.'),this.addValidator.apply(this,arguments))},removeValidator:function(e){return this.validators[e]||o.warn('Validator "'+e+'" is not defined.'),delete this.validators[e],this},_setValidator:function(e,t,i){"object"!=typeof t&&(t={fn:t,priority:i}),t.validate||(t=new f(t)),this.validators[e]=t;for(var n in t.messages||{})this.addMessage(n,e,t.messages[n]);return this},getErrorMessage:function(e){var t;if("type"===e.name){var i=this.catalog[this.locale][e.name]||{};t=i[e.requirements]}else t=this.formatMessage(this.catalog[this.locale][e.name],e.requirements);return t||this.catalog[this.locale].defaultMessage||this.catalog.en.defaultMessage},formatMessage:function(e,t){if("object"==typeof t){for(var i in t)e=this.formatMessage(e,t[i]);return e}return"string"==typeof e?e.replace(/%s/i,t):""},validators:{notblank:{validateString:function(e){return/\S/.test(e)},priority:2},required:{validateMultiple:function(e){return e.length>0},validateString:function(e){return/\S/.test(e)},priority:512},type:{validateString:function(e,t){var i=arguments.length<=2||void 0===arguments[2]?{}:arguments[2],n=i.step,r=void 0===n?"1":n,s=i.base,a=void 0===s?0:s,o=g[t];if(!o)throw new Error("validator type `"+t+"` is not supported");if(!o.test(e))return!1;if("number"===t&&!/^any$/i.test(r||"")){var l=Number(e),u=Math.max(v(r),v(a));if(v(l)>u)return!1;var d=function(e){return Math.round(e*Math.pow(10,u))};if((d(l)-d(a))%d(r)!=0)return!1}return!0},requirementType:{"":"string",step:"string",base:"number"},priority:256},pattern:{validateString:function(e,t){return t.test(e)},requirementType:"regexp",priority:64},minlength:{validateString:function(e,t){return e.length>=t},requirementType:"integer",priority:30},maxlength:{validateString:function(e,t){return e.length<=t},requirementType:"integer",priority:30},length:{validateString:function(e,t,i){return e.length>=t&&e.length<=i},requirementType:["integer","integer"],priority:30},mincheck:{validateMultiple:function(e,t){return e.length>=t},requirementType:"integer",priority:30},maxcheck:{validateMultiple:function(e,t){return e.length<=t},requirementType:"integer",priority:30},check:{validateMultiple:function(e,t,i){return e.length>=t&&e.length<=i},requirementType:["integer","integer"],priority:30},min:{validateNumber:function(e,t){return e>=t},requirementType:"number",priority:30},max:{validateNumber:function(e,t){return t>=e},requirementType:"number",priority:30},range:{validateNumber:function(e,t,i){return e>=t&&i>=e},requirementType:["number","number"],priority:30},equalto:{validateString:function(t,i){var n=e(i);return n.length?t===n.val():t===i},priority:256}}};var y={},_=function k(e,t,i){for(var n=[],r=[],s=0;s<e.length;s++){for(var a=!1,o=0;o<t.length;o++)if(e[s].assert.name===t[o].assert.name){a=!0;break}a?r.push(e[s]):n.push(e[s])}return{kept:r,added:n,removed:i?[]:k(t,e,!0).added}};y.Form={_actualizeTriggers:function(){var e=this;this.$element.on("submit.Parsley",function(t){e.onSubmitValidate(t)}),this.$element.on("click.Parsley",'input[type="submit"], button[type="submit"]',function(t){e.onSubmitButton(t)}),!1!==this.options.uiEnabled&&this.$element.attr("novalidate","")},focus:function(){if(this._focusedField=null,!0===this.validationResult||"none"===this.options.focus)return null;for(var e=0;e<this.fields.length;e++){var t=this.fields[e];if(!0!==t.validationResult&&t.validationResult.length>0&&"undefined"==typeof t.options.noFocus&&(this._focusedField=t.$element,"first"===this.options.focus))break}return null===this._focusedField?null:this._focusedField.focus()},_destroyUI:function(){this.$element.off(".Parsley")}},y.Field={_reflowUI:function(){if(this._buildUI(),this._ui){var e=_(this.validationResult,this._ui.lastValidationResult);this._ui.lastValidationResult=this.validationResult,this._manageStatusClass(),this._manageErrorsMessages(e),this._actualizeTriggers(),!e.kept.length&&!e.added.length||this._failedOnce||(this._failedOnce=!0,this._actualizeTriggers())}},getErrorsMessages:function(){if(!0===this.validationResult)return[];for(var e=[],t=0;t<this.validationResult.length;t++)e.push(this.validationResult[t].errorMessage||this._getErrorMessage(this.validationResult[t].assert));return e},addError:function(e){var t=arguments.length<=1||void 0===arguments[1]?{}:arguments[1],i=t.message,n=t.assert,r=t.updateClass,s=void 0===r?!0:r;this._buildUI(),this._addError(e,{message:i,assert:n}),s&&this._errorClass()},updateError:function(e){var t=arguments.length<=1||void 0===arguments[1]?{}:arguments[1],i=t.message,n=t.assert,r=t.updateClass,s=void 0===r?!0:r;this._buildUI(),this._updateError(e,{message:i,assert:n}),s&&this._errorClass()},removeError:function(e){var t=arguments.length<=1||void 0===arguments[1]?{}:arguments[1],i=t.updateClass,n=void 0===i?!0:i;this._buildUI(),this._removeError(e),n&&this._manageStatusClass()},_manageStatusClass:function(){this.hasConstraints()&&this.needsValidation()&&!0===this.validationResult?this._successClass():this.validationResult.length>0?this._errorClass():this._resetClass()},_manageErrorsMessages:function(t){if("undefined"==typeof this.options.errorsMessagesDisabled){if("undefined"!=typeof this.options.errorMessage)return t.added.length||t.kept.length?(this._insertErrorWrapper(),0===this._ui.$errorsWrapper.find(".parsley-custom-error-message").length&&this._ui.$errorsWrapper.append(e(this.options.errorTemplate).addClass("parsley-custom-error-message")),this._ui.$errorsWrapper.addClass("filled").find(".parsley-custom-error-message").html(this.options.errorMessage)):this._ui.$errorsWrapper.removeClass("filled").find(".parsley-custom-error-message").remove();for(var i=0;i<t.removed.length;i++)this._removeError(t.removed[i].assert.name);for(i=0;i<t.added.length;i++)this._addError(t.added[i].assert.name,{message:t.added[i].errorMessage,assert:t.added[i].assert});for(i=0;i<t.kept.length;i++)this._updateError(t.kept[i].assert.name,{message:t.kept[i].errorMessage,assert:t.kept[i].assert})}},_addError:function(t,i){var n=i.message,r=i.assert;this._insertErrorWrapper(),this._ui.$errorsWrapper.addClass("filled").append(e(this.options.errorTemplate).addClass("parsley-"+t).html(n||this._getErrorMessage(r)))},_updateError:function(e,t){var i=t.message,n=t.assert;this._ui.$errorsWrapper.addClass("filled").find(".parsley-"+e).html(i||this._getErrorMessage(n))},_removeError:function(e){this._ui.$errorsWrapper.removeClass("filled").find(".parsley-"+e).remove()},_getErrorMessage:function(e){var t=e.name+"Message";return"undefined"!=typeof this.options[t]?window.Parsley.formatMessage(this.options[t],e.requirements):window.Parsley.getErrorMessage(e)},_buildUI:function(){if(!this._ui&&!1!==this.options.uiEnabled){var t={};this.$element.attr(this.options.namespace+"id",this.__id__),t.$errorClassHandler=this._manageClassHandler(),t.errorsWrapperId="parsley-id-"+(this.options.multiple?"multiple-"+this.options.multiple:this.__id__),t.$errorsWrapper=e(this.options.errorsWrapper).attr("id",t.errorsWrapperId),t.lastValidationResult=[],t.validationInformationVisible=!1,this._ui=t}},_manageClassHandler:function(){if("string"==typeof this.options.classHandler&&e(this.options.classHandler).length)return e(this.options.classHandler);var t=this.options.classHandler.call(this,this);return"undefined"!=typeof t&&t.length?t:!this.options.multiple||this.$element.is("select")?this.$element:this.$element.parent()},_insertErrorWrapper:function(){var t;if(0!==this._ui.$errorsWrapper.parent().length)return this._ui.$errorsWrapper.parent();if("string"==typeof this.options.errorsContainer){if(e(this.options.errorsContainer).length)return e(this.options.errorsContainer).append(this._ui.$errorsWrapper);o.warn("The errors container `"+this.options.errorsContainer+"` does not exist in DOM")}else"function"==typeof this.options.errorsContainer&&(t=this.options.errorsContainer.call(this,this));if("undefined"!=typeof t&&t.length)return t.append(this._ui.$errorsWrapper);var i=this.$element;return this.options.multiple&&(i=i.parent()),i.after(this._ui.$errorsWrapper)},_actualizeTriggers:function(){var e,t=this,i=this._findRelated();i.off(".Parsley"),this._failedOnce?i.on(o.namespaceEvents(this.options.triggerAfterFailure,"Parsley"),function(){t.validate()}):(e=o.namespaceEvents(this.options.trigger,"Parsley"))&&i.on(e,function(e){t._eventValidate(e)})},_eventValidate:function(e){!(!/key|input/.test(e.type)||this._ui&&this._ui.validationInformationVisible)&&this.getValue().length<=this.options.validationThreshold||this.validate()},_resetUI:function(){this._failedOnce=!1,this._actualizeTriggers(),"undefined"!=typeof this._ui&&(this._ui.$errorsWrapper.removeClass("filled").children().remove(),this._resetClass(),this._ui.lastValidationResult=[],this._ui.validationInformationVisible=!1)},_destroyUI:function(){this._resetUI(),"undefined"!=typeof this._ui&&this._ui.$errorsWrapper.remove(),delete this._ui},_successClass:function(){this._ui.validationInformationVisible=!0,this._ui.$errorClassHandler.removeClass(this.options.errorClass).addClass(this.options.successClass)},_errorClass:function(){this._ui.validationInformationVisible=!0,this._ui.$errorClassHandler.removeClass(this.options.successClass).addClass(this.options.errorClass)},_resetClass:function(){this._ui.$errorClassHandler.removeClass(this.options.successClass).removeClass(this.options.errorClass)}};var w=function(t,i,n){this.__class__="ParsleyForm",this.$element=e(t),this.domOptions=i,this.options=n,this.parent=window.Parsley,this.fields=[],this.validationResult=null},b={pending:null,resolved:!0,rejected:!1};w.prototype={onSubmitValidate:function(e){var t=this;if(!0!==e.parsley){var i=this._$submitSource||this.$element.find('input[type="submit"], button[type="submit"]').first();if(this._$submitSource=null,this.$element.find(".parsley-synthetic-submit-button").prop("disabled",!0),!i.is("[formnovalidate]")){var n=this.whenValidate({event:e});"resolved"===n.state()&&!1!==this._trigger("submit")||(e.stopImmediatePropagation(),e.preventDefault(),"pending"===n.state()&&n.done(function(){t._submit(i)}))}}},onSubmitButton:function(t){this._$submitSource=e(t.currentTarget)},_submit:function(t){if(!1!==this._trigger("submit")){if(t){var i=this.$element.find(".parsley-synthetic-submit-button").prop("disabled",!1);0===i.length&&(i=e('<input class="parsley-synthetic-submit-button" type="hidden">').appendTo(this.$element)),i.attr({name:t.attr("name"),value:t.attr("value")})}this.$element.trigger(e.extend(e.Event("submit"),{parsley:!0}))}},validate:function(t){if(arguments.length>=1&&!e.isPlainObject(t)){o.warnOnce("Calling validate on a parsley form without passing arguments as an object is deprecated.");var i=_slice.call(arguments),n=i[0],r=i[1],s=i[2];t={group:n,force:r,event:s}}return b[this.whenValidate(t).state()]},whenValidate:function(){var t,i=this,n=arguments.length<=0||void 0===arguments[0]?{}:arguments[0],r=n.group,s=n.force,a=n.event;this.submitEvent=a,a&&(this.submitEvent=e.extend({},a,{preventDefault:function(){o.warnOnce("Using `this.submitEvent.preventDefault()` is deprecated; instead, call `this.validationResult = false`"),i.validationResult=!1}})),this.validationResult=!0,this._trigger("validate"),this._refreshFields();var l=this._withoutReactualizingFormOptions(function(){return e.map(i.fields,function(e){return e.whenValidate({force:s,group:r})})});return(t=o.all(l).done(function(){i._trigger("success")}).fail(function(){i.validationResult=!1,i.focus(),i._trigger("error")}).always(function(){i._trigger("validated")})).pipe.apply(t,_toConsumableArray(this._pipeAccordingToValidationResult()))},isValid:function(t){if(arguments.length>=1&&!e.isPlainObject(t)){o.warnOnce("Calling isValid on a parsley form without passing arguments as an object is deprecated.");var i=_slice.call(arguments),n=i[0],r=i[1];t={group:n,force:r}}return b[this.whenValid(t).state()]},whenValid:function(){var t=this,i=arguments.length<=0||void 0===arguments[0]?{}:arguments[0],n=i.group,r=i.force;this._refreshFields();var s=this._withoutReactualizingFormOptions(function(){return e.map(t.fields,function(e){return e.whenValid({group:n,force:r})})});return o.all(s)},_refreshFields:function(){return this.actualizeOptions()._bindFields()},_bindFields:function(){var t=this,i=this.fields;return this.fields=[],this.fieldsMappedById={},this._withoutReactualizingFormOptions(function(){t.$element.find(t.options.inputs).not(t.options.excluded).each(function(e,i){var n=new window.Parsley.Factory(i,{},t);"ParsleyField"!==n.__class__&&"ParsleyFieldMultiple"!==n.__class__||!0===n.options.excluded||"undefined"==typeof t.fieldsMappedById[n.__class__+"-"+n.__id__]&&(t.fieldsMappedById[n.__class__+"-"+n.__id__]=n,t.fields.push(n))}),e.each(o.difference(i,t.fields),function(e,t){t._trigger("reset")})}),this},_withoutReactualizingFormOptions:function(e){var t=this.actualizeOptions;this.actualizeOptions=function(){return this};var i=e();return this.actualizeOptions=t,i},_trigger:function(e){return this.trigger("form:"+e)}};var F=function(t,i,n,r,s){if(!/ParsleyField/.test(t.__class__))throw new Error("ParsleyField or ParsleyFieldMultiple instance expected");var a=window.Parsley._validatorRegistry.validators[i],o=new f(a);e.extend(this,{validator:o,name:i,requirements:n,priority:r||t.options[i+"Priority"]||o.priority,isDomConstraint:!0===s}),this._parseRequirements(t.options)},C=function(e){var t=e[0].toUpperCase();return t+e.slice(1)};F.prototype={validate:function(e,t){var i;return(i=this.validator).validate.apply(i,[e].concat(_toConsumableArray(this.requirementList),[t]))},_parseRequirements:function(e){var t=this;this.requirementList=this.validator.parseRequirements(this.requirements,function(i){return e[t.name+C(i)]})}};var $=function(t,i,n,r){this.__class__="ParsleyField",this.$element=e(t),"undefined"!=typeof r&&(this.parent=r),this.options=n,this.domOptions=i,this.constraints=[],this.constraintsByName={},this.validationResult=!0,this._bindConstraints()},x={pending:null,resolved:!0,rejected:!1};$.prototype={validate:function(t){arguments.length>=1&&!e.isPlainObject(t)&&(o.warnOnce("Calling validate on a parsley field without passing arguments as an object is deprecated."),t={options:t});var i=this.whenValidate(t);if(!i)return!0;switch(i.state()){case"pending":return null;case"resolved":return!0;case"rejected":return this.validationResult}},whenValidate:function(){var e,t=this,i=arguments.length<=0||void 0===arguments[0]?{}:arguments[0],n=i.force,r=i.group;return this.refreshConstraints(),!r||this._isInGroup(r)?(this.value=this.getValue(),this._trigger("validate"),(e=this.whenValid({force:n,value:this.value,_refreshed:!0}).always(function(){t._reflowUI()}).done(function(){t._trigger("success")}).fail(function(){t._trigger("error")}).always(function(){t._trigger("validated")})).pipe.apply(e,_toConsumableArray(this._pipeAccordingToValidationResult()))):void 0},hasConstraints:function(){return 0!==this.constraints.length},needsValidation:function(e){return"undefined"==typeof e&&(e=this.getValue()),!(!e.length&&!this._isRequired()&&"undefined"==typeof this.options.validateIfEmpty)},_isInGroup:function(t){return e.isArray(this.options.group)?-1!==e.inArray(t,this.options.group):this.options.group===t},isValid:function(t){if(arguments.length>=1&&!e.isPlainObject(t)){o.warnOnce("Calling isValid on a parsley field without passing arguments as an object is deprecated.");var i=_slice.call(arguments),n=i[0],r=i[1];t={force:n,value:r}}var s=this.whenValid(t);return s?x[s.state()]:!0},whenValid:function(){var t=this,i=arguments.length<=0||void 0===arguments[0]?{}:arguments[0],n=i.force,r=void 0===n?!1:n,s=i.value,a=i.group,l=i._refreshed;if(l||this.refreshConstraints(),!a||this._isInGroup(a)){if(this.validationResult=!0,!this.hasConstraints())return e.when();if("undefined"!=typeof s&&null!==s||(s=this.getValue()),!this.needsValidation(s)&&!0!==r)return e.when();var u=this._getGroupedConstraints(),d=[];return e.each(u,function(i,n){var r=o.all(e.map(n,function(e){return t._validateConstraint(s,e)}));return d.push(r),"rejected"===r.state()?!1:void 0}),o.all(d)}},_validateConstraint:function(t,i){var n=this,r=i.validate(t,this);return!1===r&&(r=e.Deferred().reject()),o.all([r]).fail(function(e){n.validationResult instanceof Array||(n.validationResult=[]),n.validationResult.push({assert:i,errorMessage:"string"==typeof e&&e})})},getValue:function(){var e;return e="function"==typeof this.options.value?this.options.value(this):"undefined"!=typeof this.options.value?this.options.value:this.$element.val(),"undefined"==typeof e||null===e?"":this._handleWhitespace(e)},refreshConstraints:function(){return this.actualizeOptions()._bindConstraints()},addConstraint:function(e,t,i,n){if(window.Parsley._validatorRegistry.validators[e]){var r=new F(this,e,t,i,n);"undefined"!==this.constraintsByName[r.name]&&this.removeConstraint(r.name),this.constraints.push(r),this.constraintsByName[r.name]=r}return this},removeConstraint:function(e){for(var t=0;t<this.constraints.length;t++)if(e===this.constraints[t].name){this.constraints.splice(t,1);break}return delete this.constraintsByName[e],this},updateConstraint:function(e,t,i){return this.removeConstraint(e).addConstraint(e,t,i)},_bindConstraints:function(){for(var e=[],t={},i=0;i<this.constraints.length;i++)!1===this.constraints[i].isDomConstraint&&(e.push(this.constraints[i]),t[this.constraints[i].name]=this.constraints[i]);this.constraints=e,this.constraintsByName=t;for(var n in this.options)this.addConstraint(n,this.options[n],void 0,!0);return this._bindHtml5Constraints()},_bindHtml5Constraints:function(){(this.$element.hasClass("required")||this.$element.attr("required"))&&this.addConstraint("required",!0,void 0,!0),"string"==typeof this.$element.attr("pattern")&&this.addConstraint("pattern",this.$element.attr("pattern"),void 0,!0),"undefined"!=typeof this.$element.attr("min")&&"undefined"!=typeof this.$element.attr("max")?this.addConstraint("range",[this.$element.attr("min"),this.$element.attr("max")],void 0,!0):"undefined"!=typeof this.$element.attr("min")?this.addConstraint("min",this.$element.attr("min"),void 0,!0):"undefined"!=typeof this.$element.attr("max")&&this.addConstraint("max",this.$element.attr("max"),void 0,!0),"undefined"!=typeof this.$element.attr("minlength")&&"undefined"!=typeof this.$element.attr("maxlength")?this.addConstraint("length",[this.$element.attr("minlength"),this.$element.attr("maxlength")],void 0,!0):"undefined"!=typeof this.$element.attr("minlength")?this.addConstraint("minlength",this.$element.attr("minlength"),void 0,!0):"undefined"!=typeof this.$element.attr("maxlength")&&this.addConstraint("maxlength",this.$element.attr("maxlength"),void 0,!0);var e=this.$element.attr("type");return"undefined"==typeof e?this:"number"===e?this.addConstraint("type",["number",{step:this.$element.attr("step"),base:this.$element.attr("min")||this.$element.attr("value")}],void 0,!0):/^(email|url|range)$/i.test(e)?this.addConstraint("type",e,void 0,!0):this},_isRequired:function(){return"undefined"==typeof this.constraintsByName.required?!1:!1!==this.constraintsByName.required.requirements},_trigger:function(e){return this.trigger("field:"+e)},_handleWhitespace:function(e){return!0===this.options.trimValue&&o.warnOnce('data-parsley-trim-value="true" is deprecated, please use data-parsley-whitespace="trim"'),"squish"===this.options.whitespace&&(e=e.replace(/\s{2,}/g," ")),"trim"!==this.options.whitespace&&"squish"!==this.options.whitespace&&!0!==this.options.trimValue||(e=o.trimString(e)),e},_getGroupedConstraints:function(){if(!1===this.options.priorityEnabled)return[this.constraints];for(var e=[],t={},i=0;i<this.constraints.length;i++){var n=this.constraints[i].priority;t[n]||e.push(t[n]=[]),t[n].push(this.constraints[i])}return e.sort(function(e,t){return t[0].priority-e[0].priority}),e}};var E=$,P=function(){this.__class__="ParsleyFieldMultiple"};P.prototype={addElement:function(e){return this.$elements.push(e),this},refreshConstraints:function(){var t;if(this.constraints=[],this.$element.is("select"))return this.actualizeOptions()._bindConstraints(),this;for(var i=0;i<this.$elements.length;i++)if(e("html").has(this.$elements[i]).length){t=this.$elements[i].data("ParsleyFieldMultiple").refreshConstraints().constraints;for(var n=0;n<t.length;n++)this.addConstraint(t[n].name,t[n].requirements,t[n].priority,t[n].isDomConstraint)}else this.$elements.splice(i,1);return this},getValue:function(){if("function"==typeof this.options.value)return this.options.value(this);if("undefined"!=typeof this.options.value)return this.options.value;if(this.$element.is("input[type=radio]"))return this._findRelated().filter(":checked").val()||"";if(this.$element.is("input[type=checkbox]")){var t=[];return this._findRelated().filter(":checked").each(function(){t.push(e(this).val())}),t}return this.$element.is("select")&&null===this.$element.val()?[]:this.$element.val()},_init:function(){return this.$elements=[this.$element],this}};var V=function(t,i,n){this.$element=e(t);var r=this.$element.data("Parsley");if(r)return"undefined"!=typeof n&&r.parent===window.Parsley&&(r.parent=n,r._resetOptions(r.options)),"object"==typeof i&&e.extend(r.options,i),r;if(!this.$element.length)throw new Error("You must bind Parsley on an existing element.");if("undefined"!=typeof n&&"ParsleyForm"!==n.__class__)throw new Error("Parent instance must be a ParsleyForm instance");return this.parent=n||window.Parsley,this.init(i)};V.prototype={init:function(e){return this.__class__="Parsley",this.__version__="2.4.3",this.__id__=o.generateID(),this._resetOptions(e),this.$element.is("form")||o.checkAttr(this.$element,this.options.namespace,"validate")&&!this.$element.is(this.options.inputs)?this.bind("parsleyForm"):this.isMultiple()?this.handleMultiple():this.bind("parsleyField")},isMultiple:function(){return this.$element.is("input[type=radio], input[type=checkbox]")||this.$element.is("select")&&"undefined"!=typeof this.$element.attr("multiple")},handleMultiple:function(){var t,i,n=this;if(this.options.multiple||("undefined"!=typeof this.$element.attr("name")&&this.$element.attr("name").length?this.options.multiple=t=this.$element.attr("name"):"undefined"!=typeof this.$element.attr("id")&&this.$element.attr("id").length&&(this.options.multiple=this.$element.attr("id"))),
    this.$element.is("select")&&"undefined"!=typeof this.$element.attr("multiple"))return this.options.multiple=this.options.multiple||this.__id__,this.bind("parsleyFieldMultiple");if(!this.options.multiple)return o.warn("To be bound by Parsley, a radio, a checkbox and a multiple select input must have either a name or a multiple option.",this.$element),this;this.options.multiple=this.options.multiple.replace(/(:|\.|\[|\]|\{|\}|\$)/g,""),"undefined"!=typeof t&&e('input[name="'+t+'"]').each(function(t,i){e(i).is("input[type=radio], input[type=checkbox]")&&e(i).attr(n.options.namespace+"multiple",n.options.multiple)});for(var r=this._findRelated(),s=0;s<r.length;s++)if(i=e(r.get(s)).data("Parsley"),"undefined"!=typeof i){this.$element.data("ParsleyFieldMultiple")||i.addElement(this.$element);break}return this.bind("parsleyField",!0),i||this.bind("parsleyFieldMultiple")},bind:function(t,i){var n;switch(t){case"parsleyForm":n=e.extend(new w(this.$element,this.domOptions,this.options),new u,window.ParsleyExtend)._bindFields();break;case"parsleyField":n=e.extend(new E(this.$element,this.domOptions,this.options,this.parent),new u,window.ParsleyExtend);break;case"parsleyFieldMultiple":n=e.extend(new E(this.$element,this.domOptions,this.options,this.parent),new P,new u,window.ParsleyExtend)._init();break;default:throw new Error(t+"is not a supported Parsley type")}return this.options.multiple&&o.setAttr(this.$element,this.options.namespace,"multiple",this.options.multiple),"undefined"!=typeof i?(this.$element.data("ParsleyFieldMultiple",n),n):(this.$element.data("Parsley",n),n._actualizeTriggers(),n._trigger("init"),n)}};var M=e.fn.jquery.split(".");if(parseInt(M[0])<=1&&parseInt(M[1])<8)throw"The loaded version of jQuery is too old. Please upgrade to 1.8.x or better.";M.forEach||o.warn("Parsley requires ES5 to run properly. Please include https://github.com/es-shims/es5-shim");var O=e.extend(new u,{$element:e(document),actualizeOptions:null,_resetOptions:null,Factory:V,version:"2.4.3"});e.extend(E.prototype,y.Field,u.prototype),e.extend(w.prototype,y.Form,u.prototype),e.extend(V.prototype,u.prototype),e.fn.parsley=e.fn.psly=function(t){if(this.length>1){var i=[];return this.each(function(){i.push(e(this).parsley(t))}),i}return e(this).length?new V(this,t):void o.warn("You must bind Parsley on an existing element.")},"undefined"==typeof window.ParsleyExtend&&(window.ParsleyExtend={}),O.options=e.extend(o.objectCreate(l),window.ParsleyConfig),window.ParsleyConfig=O.options,window.Parsley=window.psly=O,window.ParsleyUtils=o;var A=window.Parsley._validatorRegistry=new m(window.ParsleyConfig.validators,window.ParsleyConfig.i18n);window.ParsleyValidator={},e.each("setLocale addCatalog addMessage addMessages getErrorMessage formatMessage addValidator updateValidator removeValidator".split(" "),function(t,i){window.Parsley[i]=e.proxy(A,i),window.ParsleyValidator[i]=function(){var e;return o.warnOnce("Accessing the method '"+i+"' through ParsleyValidator is deprecated. Simply call 'window.Parsley."+i+"(...)'"),(e=window.Parsley)[i].apply(e,arguments)}}),window.Parsley.UI=y,window.ParsleyUI={removeError:function(e,t,i){var n=!0!==i;return o.warnOnce("Accessing ParsleyUI is deprecated. Call 'removeError' on the instance directly. Please comment in issue 1073 as to your need to call this method."),e.removeError(t,{updateClass:n})},getErrorsMessages:function(e){return o.warnOnce("Accessing ParsleyUI is deprecated. Call 'getErrorsMessages' on the instance directly."),e.getErrorsMessages()}},e.each("addError updateError".split(" "),function(e,t){window.ParsleyUI[t]=function(e,i,n,r,s){var a=!0!==s;return o.warnOnce("Accessing ParsleyUI is deprecated. Call '"+t+"' on the instance directly. Please comment in issue 1073 as to your need to call this method."),e[t](i,{message:n,assert:r,updateClass:a})}}),!1!==window.ParsleyConfig.autoBind&&e(function(){e("[data-parsley-validate]").length&&e("[data-parsley-validate]").parsley()});var R=e({}),T=function(){o.warnOnce("Parsley's pubsub module is deprecated; use the 'on' and 'off' methods on parsley instances or window.Parsley")},q="parsley:";e.listen=function(e,n){var r;if(T(),"object"==typeof arguments[1]&&"function"==typeof arguments[2]&&(r=arguments[1],n=arguments[2]),"function"!=typeof n)throw new Error("Wrong parameters");window.Parsley.on(i(e),t(n,r))},e.listenTo=function(e,n,r){if(T(),!(e instanceof E||e instanceof w))throw new Error("Must give Parsley instance");if("string"!=typeof n||"function"!=typeof r)throw new Error("Wrong parameters");e.on(i(n),t(r))},e.unsubscribe=function(e,t){if(T(),"string"!=typeof e||"function"!=typeof t)throw new Error("Wrong arguments");window.Parsley.off(i(e),t.parsleyAdaptedCallback)},e.unsubscribeTo=function(e,t){if(T(),!(e instanceof E||e instanceof w))throw new Error("Must give Parsley instance");e.off(i(t))},e.unsubscribeAll=function(t){T(),window.Parsley.off(i(t)),e("form,input,textarea,select").each(function(){var n=e(this).data("Parsley");n&&n.off(i(t))})},e.emit=function(e,t){var n;T();var r=t instanceof E||t instanceof w,s=Array.prototype.slice.call(arguments,r?2:1);s.unshift(i(e)),r||(t=window.Parsley),(n=t).trigger.apply(n,_toConsumableArray(s))};e.extend(!0,O,{asyncValidators:{"default":{fn:function(e){return e.status>=200&&e.status<300},url:!1},reverse:{fn:function(e){return e.status<200||e.status>=300},url:!1}},addAsyncValidator:function(e,t,i,n){return O.asyncValidators[e]={fn:t,url:i||!1,options:n||{}},this}}),O.addValidator("remote",{requirementType:{"":"string",validator:"string",reverse:"boolean",options:"object"},validateString:function(t,i,n,r){var s,a,o={},l=n.validator||(!0===n.reverse?"reverse":"default");if("undefined"==typeof O.asyncValidators[l])throw new Error("Calling an undefined async validator: `"+l+"`");i=O.asyncValidators[l].url||i,i.indexOf("{value}")>-1?i=i.replace("{value}",encodeURIComponent(t)):o[r.$element.attr("name")||r.$element.attr("id")]=t;var u=e.extend(!0,n.options||{},O.asyncValidators[l].options);s=e.extend(!0,{},{url:i,data:o,type:"GET"},u),r.trigger("field:ajaxoptions",r,s),a=e.param(s),"undefined"==typeof O._remoteCache&&(O._remoteCache={});var d=O._remoteCache[a]=O._remoteCache[a]||e.ajax(s),h=function(){var t=O.asyncValidators[l].fn.call(r,d,i,n);return t||(t=e.Deferred().reject()),e.when(t)};return d.then(h,h)},priority:-1}),O.on("form:submit",function(){O._remoteCache={}}),window.ParsleyExtend.addAsyncValidator=function(){return ParsleyUtils.warnOnce("Accessing the method `addAsyncValidator` through an instance is deprecated. Simply call `Parsley.addAsyncValidator(...)`"),O.addAsyncValidator.apply(O,arguments)},O.addMessages("en",{defaultMessage:"This value seems to be invalid.",type:{email:"This value should be a valid email.",url:"This value should be a valid url.",number:"This value should be a valid number.",integer:"This value should be a valid integer.",digits:"This value should be digits.",alphanum:"This value should be alphanumeric."},notblank:"This value should not be blank.",required:"This value is required.",pattern:"This value seems to be invalid.",min:"This value should be greater than or equal to %s.",max:"This value should be lower than or equal to %s.",range:"This value should be between %s and %s.",minlength:"This value is too short. It should have %s characters or more.",maxlength:"This value is too long. It should have %s characters or fewer.",length:"This value length is invalid. It should be between %s and %s characters long.",mincheck:"You must select at least %s choices.",maxcheck:"You must select %s choices or fewer.",check:"You must select between %s and %s choices.",equalto:"This value should be the same."}),O.setLocale("en");var D=new n;D.install();var I=O;return I});
//# sourceMappingURL=parsley.min.js.map
/* ========================================================================
 * Bootstrap: modal.js v3.3.6
 * http://getbootstrap.com/javascript/#modals
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // MODAL CLASS DEFINITION
  // ======================

  var Modal = function (element, options) {
    this.options             = options
    this.$body               = $(document.body)
    this.$element            = $(element)
    this.$dialog             = this.$element.find('.modal-dialog')
    this.$backdrop           = null
    this.isShown             = null
    this.originalBodyPad     = null
    this.scrollbarWidth      = 0
    this.ignoreBackdropClick = false

    if (this.options.remote) {
      this.$element
        .find('.modal-content')
        .load(this.options.remote, $.proxy(function () {
          this.$element.trigger('loaded.bs.modal')
        }, this))
    }
  }

  Modal.VERSION  = '3.3.6'

  Modal.TRANSITION_DURATION = 300
  Modal.BACKDROP_TRANSITION_DURATION = 150

  Modal.DEFAULTS = {
    backdrop: true,
    keyboard: true,
    show: true
  }

  Modal.prototype.toggle = function (_relatedTarget) {
    return this.isShown ? this.hide() : this.show(_relatedTarget)
  }

  Modal.prototype.show = function (_relatedTarget) {
    var that = this
    var e    = $.Event('show.bs.modal', { relatedTarget: _relatedTarget })

    this.$element.trigger(e)

    if (this.isShown || e.isDefaultPrevented()) return

    this.isShown = true

    this.checkScrollbar()
    this.setScrollbar()
    this.$body.addClass('modal-open')

    this.escape()
    this.resize()

    this.$element.on('click.dismiss.bs.modal', '[data-dismiss="modal"]', $.proxy(this.hide, this))

    this.$dialog.on('mousedown.dismiss.bs.modal', function () {
      that.$element.one('mouseup.dismiss.bs.modal', function (e) {
        if ($(e.target).is(that.$element)) that.ignoreBackdropClick = true
      })
    })

    this.backdrop(function () {
      var transition = $.support.transition && that.$element.hasClass('fade')

      if (!that.$element.parent().length) {
        that.$element.appendTo(that.$body) // don't move modals dom position
      }

      that.$element
        .show()
        .scrollTop(0)

      that.adjustDialog()

      if (transition) {
        that.$element[0].offsetWidth // force reflow
      }

      that.$element.addClass('in')

      that.enforceFocus()

      var e = $.Event('shown.bs.modal', { relatedTarget: _relatedTarget })

      transition ?
        that.$dialog // wait for modal to slide in
          .one('bsTransitionEnd', function () {
            that.$element.trigger('focus').trigger(e)
          })
          .emulateTransitionEnd(Modal.TRANSITION_DURATION) :
        that.$element.trigger('focus').trigger(e)
    })
  }

  Modal.prototype.hide = function (e) {
    if (e) e.preventDefault()

    e = $.Event('hide.bs.modal')

    this.$element.trigger(e)

    if (!this.isShown || e.isDefaultPrevented()) return

    this.isShown = false

    this.escape()
    this.resize()

    $(document).off('focusin.bs.modal')

    this.$element
      .removeClass('in')
      .off('click.dismiss.bs.modal')
      .off('mouseup.dismiss.bs.modal')

    this.$dialog.off('mousedown.dismiss.bs.modal')

    $.support.transition && this.$element.hasClass('fade') ?
      this.$element
        .one('bsTransitionEnd', $.proxy(this.hideModal, this))
        .emulateTransitionEnd(Modal.TRANSITION_DURATION) :
      this.hideModal()
  }

  Modal.prototype.enforceFocus = function () {
    $(document)
      .off('focusin.bs.modal') // guard against infinite focus loop
      .on('focusin.bs.modal', $.proxy(function (e) {
        if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
          this.$element.trigger('focus')
        }
      }, this))
  }

  Modal.prototype.escape = function () {
    if (this.isShown && this.options.keyboard) {
      this.$element.on('keydown.dismiss.bs.modal', $.proxy(function (e) {
        e.which == 27 && this.hide()
      }, this))
    } else if (!this.isShown) {
      this.$element.off('keydown.dismiss.bs.modal')
    }
  }

  Modal.prototype.resize = function () {
    if (this.isShown) {
      $(window).on('resize.bs.modal', $.proxy(this.handleUpdate, this))
    } else {
      $(window).off('resize.bs.modal')
    }
  }

  Modal.prototype.hideModal = function () {
    var that = this
    this.$element.hide()
    this.backdrop(function () {
      that.$body.removeClass('modal-open')
      that.resetAdjustments()
      that.resetScrollbar()
      that.$element.trigger('hidden.bs.modal')
    })
  }

  Modal.prototype.removeBackdrop = function () {
    this.$backdrop && this.$backdrop.remove()
    this.$backdrop = null
  }

  Modal.prototype.backdrop = function (callback) {
    var that = this
    var animate = this.$element.hasClass('fade') ? 'fade' : ''

    if (this.isShown && this.options.backdrop) {
      var doAnimate = $.support.transition && animate

      this.$backdrop = $(document.createElement('div'))
        .addClass('modal-backdrop ' + animate)
        .appendTo(this.$body)

      this.$element.on('click.dismiss.bs.modal', $.proxy(function (e) {
        if (this.ignoreBackdropClick) {
          this.ignoreBackdropClick = false
          return
        }
        if (e.target !== e.currentTarget) return
        this.options.backdrop == 'static'
          ? this.$element[0].focus()
          : this.hide()
      }, this))

      if (doAnimate) this.$backdrop[0].offsetWidth // force reflow

      this.$backdrop.addClass('in')

      if (!callback) return

      doAnimate ?
        this.$backdrop
          .one('bsTransitionEnd', callback)
          .emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) :
        callback()

    } else if (!this.isShown && this.$backdrop) {
      this.$backdrop.removeClass('in')

      var callbackRemove = function () {
        that.removeBackdrop()
        callback && callback()
      }
      $.support.transition && this.$element.hasClass('fade') ?
        this.$backdrop
          .one('bsTransitionEnd', callbackRemove)
          .emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) :
        callbackRemove()

    } else if (callback) {
      callback()
    }
  }

  // these following methods are used to handle overflowing modals

  Modal.prototype.handleUpdate = function () {
    this.adjustDialog()
  }

  Modal.prototype.adjustDialog = function () {
    var modalIsOverflowing = this.$element[0].scrollHeight > document.documentElement.clientHeight

    this.$element.css({
      paddingLeft:  !this.bodyIsOverflowing && modalIsOverflowing ? this.scrollbarWidth : '',
      paddingRight: this.bodyIsOverflowing && !modalIsOverflowing ? this.scrollbarWidth : ''
    })
  }

  Modal.prototype.resetAdjustments = function () {
    this.$element.css({
      paddingLeft: '',
      paddingRight: ''
    })
  }

  Modal.prototype.checkScrollbar = function () {
    var fullWindowWidth = window.innerWidth
    if (!fullWindowWidth) { // workaround for missing window.innerWidth in IE8
      var documentElementRect = document.documentElement.getBoundingClientRect()
      fullWindowWidth = documentElementRect.right - Math.abs(documentElementRect.left)
    }
    this.bodyIsOverflowing = document.body.clientWidth < fullWindowWidth
    this.scrollbarWidth = this.measureScrollbar()
  }

  Modal.prototype.setScrollbar = function () {
    var bodyPad = parseInt((this.$body.css('padding-right') || 0), 10)
    this.originalBodyPad = document.body.style.paddingRight || ''
    if (this.bodyIsOverflowing) this.$body.css('padding-right', bodyPad + this.scrollbarWidth)
  }

  Modal.prototype.resetScrollbar = function () {
    this.$body.css('padding-right', this.originalBodyPad)
  }

  Modal.prototype.measureScrollbar = function () { // thx walsh
    var scrollDiv = document.createElement('div')
    scrollDiv.className = 'modal-scrollbar-measure'
    this.$body.append(scrollDiv)
    var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth
    this.$body[0].removeChild(scrollDiv)
    return scrollbarWidth
  }


  // MODAL PLUGIN DEFINITION
  // =======================

  function Plugin(option, _relatedTarget) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.modal')
      var options = $.extend({}, Modal.DEFAULTS, $this.data(), typeof option == 'object' && option)

      if (!data) $this.data('bs.modal', (data = new Modal(this, options)))
      if (typeof option == 'string') data[option](_relatedTarget)
      else if (options.show) data.show(_relatedTarget)
    })
  }

  var old = $.fn.modal

  $.fn.modal             = Plugin
  $.fn.modal.Constructor = Modal


  // MODAL NO CONFLICT
  // =================

  $.fn.modal.noConflict = function () {
    $.fn.modal = old
    return this
  }


  // MODAL DATA-API
  // ==============

  $(document).on('click.bs.modal.data-api', '[data-toggle="modal"]', function (e) {
    var $this   = $(this)
    var href    = $this.attr('href')
    var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) // strip for ie7
    var option  = $target.data('bs.modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

    if ($this.is('a')) e.preventDefault()

    $target.one('show.bs.modal', function (showEvent) {
      if (showEvent.isDefaultPrevented()) return // only register focus restorer if modal will actually get shown
      $target.one('hidden.bs.modal', function () {
        $this.is(':visible') && $this.trigger('focus')
      })
    })
    Plugin.call($target, option, this)
  })

}(jQuery);

/**
 * circles - v0.0.6 - 2015-11-27
 *
 * Copyright (c) 2015 lugolabs
 * Licensed
 */
!function(a,b){"object"==typeof exports?module.exports=b():"function"==typeof define&&define.amd?define([],b):a.Circles=b()}(this,function(){"use strict";var a=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(a){setTimeout(a,1e3/60)},b=function(a){var b=a.id;if(this._el=document.getElementById(b),null!==this._el){this._radius=a.radius||10,this._duration=void 0===a.duration?500:a.duration,this._value=0,this._maxValue=a.maxValue||100,this._text=void 0===a.text?function(a){return this.htmlifyNumber(a)}:a.text,this._strokeWidth=a.width||10,this._colors=a.colors||["#EEE","#F00"],this._svg=null,this._movingPath=null,this._wrapContainer=null,this._textContainer=null,this._wrpClass=a.wrpClass||"circles-wrp",this._textClass=a.textClass||"circles-text",this._valClass=a.valueStrokeClass||"circles-valueStroke",this._maxValClass=a.maxValueStrokeClass||"circles-maxValueStroke",this._styleWrapper=a.styleWrapper===!1?!1:!0,this._styleText=a.styleText===!1?!1:!0;var c=Math.PI/180*270;this._start=-Math.PI/180*90,this._startPrecise=this._precise(this._start),this._circ=c-this._start,this._generate().update(a.value||0)}};return b.prototype={VERSION:"0.0.6",_generate:function(){return this._svgSize=2*this._radius,this._radiusAdjusted=this._radius-this._strokeWidth/2,this._generateSvg()._generateText()._generateWrapper(),this._el.innerHTML="",this._el.appendChild(this._wrapContainer),this},_setPercentage:function(a){this._movingPath.setAttribute("d",this._calculatePath(a,!0)),this._textContainer.innerHTML=this._getText(this.getValueFromPercent(a))},_generateWrapper:function(){return this._wrapContainer=document.createElement("div"),this._wrapContainer.className=this._wrpClass,this._styleWrapper&&(this._wrapContainer.style.position="relative",this._wrapContainer.style.display="inline-block"),this._wrapContainer.appendChild(this._svg),this._wrapContainer.appendChild(this._textContainer),this},_generateText:function(){if(this._textContainer=document.createElement("div"),this._textContainer.className=this._textClass,this._styleText){var a={position:"absolute",top:0,left:0,textAlign:"center",width:"100%",fontSize:.7*this._radius+"px",height:this._svgSize+"px",lineHeight:this._svgSize+"px"};for(var b in a)this._textContainer.style[b]=a[b]}return this._textContainer.innerHTML=this._getText(0),this},_getText:function(a){return this._text?(void 0===a&&(a=this._value),a=parseFloat(a.toFixed(2)),"function"==typeof this._text?this._text.call(this,a):this._text):""},_generateSvg:function(){return this._svg=document.createElementNS("http://www.w3.org/2000/svg","svg"),this._svg.setAttribute("xmlns","http://www.w3.org/2000/svg"),this._svg.setAttribute("width",this._svgSize),this._svg.setAttribute("height",this._svgSize),this._generatePath(100,!1,this._colors[0],this._maxValClass)._generatePath(1,!0,this._colors[1],this._valClass),this._movingPath=this._svg.getElementsByTagName("path")[1],this},_generatePath:function(a,b,c,d){var e=document.createElementNS("http://www.w3.org/2000/svg","path");return e.setAttribute("fill","transparent"),e.setAttribute("stroke",c),e.setAttribute("stroke-width",this._strokeWidth),e.setAttribute("d",this._calculatePath(a,b)),e.setAttribute("class",d),this._svg.appendChild(e),this},_calculatePath:function(a,b){var c=this._start+a/100*this._circ,d=this._precise(c);return this._arc(d,b)},_arc:function(a,b){var c=a-.001,d=a-this._startPrecise<Math.PI?0:1;return["M",this._radius+this._radiusAdjusted*Math.cos(this._startPrecise),this._radius+this._radiusAdjusted*Math.sin(this._startPrecise),"A",this._radiusAdjusted,this._radiusAdjusted,0,d,1,this._radius+this._radiusAdjusted*Math.cos(c),this._radius+this._radiusAdjusted*Math.sin(c),b?"":"Z"].join(" ")},_precise:function(a){return Math.round(1e3*a)/1e3},htmlifyNumber:function(a,b,c){b=b||"circles-integer",c=c||"circles-decimals";var d=(a+"").split("."),e='<span class="'+b+'">'+d[0]+"</span>";return d.length>1&&(e+='.<span class="'+c+'">'+d[1].substring(0,2)+"</span>"),e},updateRadius:function(a){return this._radius=a,this._generate().update(!0)},updateWidth:function(a){return this._strokeWidth=a,this._generate().update(!0)},updateColors:function(a){this._colors=a;var b=this._svg.getElementsByTagName("path");return b[0].setAttribute("stroke",a[0]),b[1].setAttribute("stroke",a[1]),this},getPercent:function(){return 100*this._value/this._maxValue},getValueFromPercent:function(a){return this._maxValue*a/100},getValue:function(){return this._value},getMaxValue:function(){return this._maxValue},update:function(b,c){if(b===!0)return this._setPercentage(this.getPercent()),this;if(this._value==b||isNaN(b))return this;void 0===c&&(c=this._duration);var d,e,f,g,h=this,i=h.getPercent(),j=1;return this._value=Math.min(this._maxValue,Math.max(0,b)),c?(d=h.getPercent(),e=d>i,j+=d%1,f=Math.floor(Math.abs(d-i)/j),g=c/f,function k(b){if(e?i+=j:i-=j,e&&i>=d||!e&&d>=i)return void a(function(){h._setPercentage(d)});a(function(){h._setPercentage(i)});var c=Date.now(),f=c-b;f>=g?k(c):setTimeout(function(){k(Date.now())},g-f)}(Date.now()),this):(this._setPercentage(this.getPercent()),this)}},b.create=function(a){return new b(a)},b});
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
//# sourceMappingURL=dashboard.js.map
