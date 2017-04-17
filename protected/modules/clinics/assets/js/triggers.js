/**
 * Created by user on 02.03.2017.
 */

Triggers = {};
Triggers.objs = [];
var $body = $('body');
function Trigger(params){
    if (typeof params != 'object') {
        params = {};
    }
    var me = {};
    me.url = params.url;
    me.verbiage = params.verbiage;
    me.children = [];
    me.element = $("#" + params.elementId);
    me.beforeDataUpdate = params.beforeDataUpdate;
    me.afterDataUpdate = params.afterDataUpdate;
    me.dataUpdate = params.dataUpdate;
    me.uncheckedValue = params.uncheckedValue;
    $(document).ready(function(){
        if (params.parentVerb) {
            me.parent = Triggers.objs[params.parentVerb];
        }
        for (var i = 0; i < params.childrenVerbs.length; i++) {
            var child = Triggers.objs[params.childrenVerbs[i]];
            if (child) {
                me.children.push(child);
            }
        }
    });
    me.changeCallback = function(){
        var val = me.element.val();
        console.log('changed '+me.verbiage);
        if (me.element.is('input[type=checkbox]')) {
            if (!me.element.is(':checked')) {
                val = me.uncheckedValue;
            }
        }
        for (var i = 0; i < me.children.length; i++) {
            me.children[i].parentChanged(val);
        }
        //$body.trigger('change.'+me.verbiage+'.triggers',{
        //$body.trigger('change.triggers',{
        //    trigger: me,
        //    newVal: val
        //});
        //alert(me.verbiage + 'changed');
        $body.trigger(me.verbiage + 'Change',{
            trigger: me,
            newVal: val
        });
    };
    me.element.change(me.changeCallback);
    me.parentChanged = function(newVal){
        //alert(newVal + ' \n' + me.url);
        //if (newVal) {
        if (!me.url) {
            return;
        }
        $.post(me.url, {
            newVal: newVal,
            parent: me.parent.verbiage
        }, null, "JSON").done(function (data) {
            if (typeof me.beforeDataUpdate == 'function') {
                me.beforeDataUpdate.call(me, data);
            }
            if (typeof me.dataUpdate == 'function') {
                me.dataUpdate.call(me, data);
            } else {
                me.element.html(data.html);
            }
            if (typeof me.afterDataUpdate == 'function') {
                me.afterDataUpdate.call(me, data);
            }
            me.changeCallback();
        });
        //} else {
        //    me.element.val('');
        //    me.element.attr('disabled','disabled');
        //    me.changeCallback();
        //}
    };
    Triggers.objs[me.verbiage] = me;
    //me.changeCallback();
    return me;
}