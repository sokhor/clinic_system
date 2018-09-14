(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["users-edit"],{3746:function(s,t,e){"use strict";e.r(t);var r=function(){var s=this,t=s.$createElement,e=s._self._c||t;return e("div",{staticClass:"w-full"},[e("div",{staticClass:"w-full flex flex-row items-center justify-between pt-4 pb-6"},[e("h1",{staticClass:"inline text-grey-darkest text-xl font-bold"},[e("router-link",{staticClass:"text-blue hover:text-blue-light",attrs:{to:"/users"}},[e("i",{staticClass:"fas fa-arrow-left"})]),s._v(" / User Reset Password\n    ")],1)]),e("div",{staticClass:"w-full bg-white shadow rounded overflow-hidden"},[e("form",{on:{submit:function(t){return t.preventDefault(),s.save(t)}}},[e("div",{staticClass:"flex items-baseline p-4 border-b border-white-grey"},[e("label",{staticClass:"block text-grey-darker text-sm font-bold w-1/5"},[s._v("\n          Username\n        ")]),e("span",{staticClass:"w-2/5"},[s._v(s._s(s.user.username))])]),e("div",{staticClass:"flex items-baseline p-4 border-b border-white-grey"},[e("label",{staticClass:"block text-grey-darker text-sm font-bold w-1/5"},[s._v("\n          Password\n        ")]),e("div",{staticClass:"w-2/5"},[e("input",{directives:[{name:"model",rawName:"v-model",value:s.form.password,expression:"form.password"}],staticClass:"appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full",attrs:{type:"password"},domProps:{value:s.form.password},on:{input:[function(t){t.target.composing||s.$set(s.form,"password",t.target.value)},function(t){s.$v.form.password.$touch()}]}}),s.passwordErrors.length>0?e("span",{staticClass:"block text-xs italic text-red"},[s._v("\n            "+s._s(s.passwordErrors[0])+"\n          ")]):s._e()])]),e("div",{staticClass:"flex items-baseline p-4 border-b border-white-grey"},[e("label",{staticClass:"block text-grey-darker text-sm font-bold w-1/5"},[s._v("\n          Password Again\n        ")]),e("div",{staticClass:"w-2/5"},[e("input",{directives:[{name:"model",rawName:"v-model",value:s.form.password_confirmation,expression:"form.password_confirmation"}],staticClass:"appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full",attrs:{type:"password"},domProps:{value:s.form.password_confirmation},on:{input:[function(t){t.target.composing||s.$set(s.form,"password_confirmation",t.target.value)},function(t){s.$v.form.password_confirmation.$touch()}]}}),s.passwordConfirmationErrors.length>0?e("span",{staticClass:"block text-xs italic text-red"},[s._v("\n            "+s._s(s.passwordConfirmationErrors[0])+"\n          ")]):s._e()])]),e("div",{staticClass:"flex items-center justify-end p-4"},[e("base-button",{attrs:{color:"primary",waiting:s.saving,type:"submit"}},[s._v("Save change")])],1)])])])},a=[],o=(e("f751"),e("96cf"),e("3040")),i=(e("cadf"),e("551c"),e("097d"),e("b5ae")),n={name:"UserForm",props:{user:{type:Object,default:null}},data:function(){return{form:{password:"",password_confirmation:""},saving:!1}},validations:{form:{password:{required:i["required"]},password_confirmation:{sameAsPassword:Object(i["sameAs"])("password")}}},computed:{passwordErrors:function(){var s=[];return this.$v.form.password.$dirty?(!this.$v.form.password.required&&s.push("Required"),s):s},passwordConfirmationErrors:function(){var s=[];return this.$v.form.password_confirmation.$dirty?(!this.$v.form.password_confirmation.sameAsPassword&&s.push("Password mismatch"),s):s}},methods:{save:function(){var s=Object(o["a"])(regeneratorRuntime.mark(function s(){return regeneratorRuntime.wrap(function(s){while(1)switch(s.prev=s.next){case 0:if(this.$v.$touch(),!this.$v.$error){s.next=3;break}throw"Validation failed";case 3:return this.saving=!0,s.prev=4,s.next=7,this.$store.dispatch("users/resetUserPassword",Object.assign(this.form,{id:this.user.id}));case 7:s.next=11;break;case 9:s.prev=9,s.t0=s["catch"](4);case 11:this.saving=!1;case 12:case"end":return s.stop()}},s,this,[[4,9]])}));return function(){return s.apply(this,arguments)}}()}},d=n,l=e("2877"),c=Object(l["a"])(d,r,a,!1,null,null,null);c.options.__file="form-reset-password.vue";t["default"]=c.exports}}]);