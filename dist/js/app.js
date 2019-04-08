!function(t){var e={};function n(s){if(e[s])return e[s].exports;var a=e[s]={i:s,l:!1,exports:{}};return t[s].call(a.exports,a,a.exports,n),a.l=!0,a.exports}n.m=t,n.c=e,n.d=function(t,e,s){n.o(t,e)||Object.defineProperty(t,e,{configurable:!1,enumerable:!0,get:s})},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=2)}([function(t,e){t.exports=function(t,e,n,s,a,o){var i,r=t=t||{},c=typeof t.default;"object"!==c&&"function"!==c||(i=t,r=t.default);var l,d="function"==typeof r?r.options:r;if(e&&(d.render=e.render,d.staticRenderFns=e.staticRenderFns,d._compiled=!0),n&&(d.functional=!0),a&&(d._scopeId=a),o?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),s&&s.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(o)},d._ssrRegister=l):s&&(l=s),l){var u=d.functional,f=u?d.render:d.beforeCreate;u?(d._injectStyles=l,d.render=function(t,e){return l.call(e),f(t,e)}):d.beforeCreate=f?[].concat(f,l):[l]}return{esModule:i,exports:r,options:d}}},function(t,e,n){"use strict";e.a={methods:{formatNextRunAt:function(t){return moment(t).fromNow().replace(/^\w/,function(t){return t.toUpperCase()})}}}},function(t,e,n){t.exports=n(3)},function(t,e,n){Nova.booting(function(t,e){t.component("nova-scheduled-tasks",n(4)),t.component("dispatch-job-modal",n(7)),e.addRoutes([{name:"NovaScheduledTasks",path:"/scheduled-tasks",component:n(10)}])})},function(t,e,n){var s=n(0)(n(5),n(6),!1,null,null,null);t.exports=s.exports},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=n(1);e.default={mixins:[s.a],props:["card"],data:function(){return{loading:!1,tasks:[]}},mounted:function(){console.log("got here"),this.fetchTasks()},methods:{fetchTasks:function(){var t=this;this.loading=!0,Nova.request().get("/nova-vendor/eagle-developers/nova-scheduled-tasks/tasks").then(function(e){t.loading=!1,t.tasks=e.data,setTimeout(t.fetchTasks,6e4)})}}}},function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("card",{staticClass:"h-auto p-4"},[n("h2",{staticClass:"text-90 font-light mb-4"},[t._v("Scheduled Tasks")]),t._v(" "),t.loading||t.tasks.length?t._e():n("p",[t._v("You do not currently have any scheduled tasks.")]),t._v(" "),t.loading?n("loader",{staticClass:"mb-4"}):t._e(),t._v(" "),!t.loading&&t.tasks.length?n("table",{staticClass:"table w-full"},[n("thead",[n("tr",[n("th",{staticClass:"text-left"},[t._v("Command")]),t._v(" "),n("th",{staticClass:"text-left"},[t._v("Expression")]),t._v(" "),n("th",{staticClass:"text-left"},[t._v("Next Run At")])])]),t._v(" "),n("tbody",t._l(t.tasks,function(e,s){return n("tr",{attrs:{task:e}},[n("td",[t._v(t._s(e.command))]),t._v(" "),n("td",[t._v(t._s(e.expression))]),t._v(" "),n("td",[t._v(t._s(t.formatNextRunAt(e.nextRunAt)))])])}),0)]):t._e()],1)},staticRenderFns:[]}},function(t,e,n){var s=n(0)(n(8),n(9),!1,null,null,null);t.exports=s.exports},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{command:String},methods:{handleClose:function(){this.$emit("close")},handleConfirm:function(){this.$emit("confirm")}},mounted:function(){this.$refs.confirmButton.focus()}}},function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("modal",{on:{"modal-close":t.handleClose},scopedSlots:t._u([{key:"default",fn:function(e){return n("form",{staticClass:"bg-white rounded-lg shadow-lg overflow-hidden",staticStyle:{width:"460px"},on:{submit:function(e){return e.preventDefault(),t.handleConfirm(e)}}},[t._t("default",[n("div",{staticClass:"p-8"},[n("heading",{staticClass:"mb-6",attrs:{level:2}},[t._v("Dispatch - "),n("b",[t._v(t._s(t.command))])]),t._v(" "),n("p",{staticClass:"text-80 leading-normal"},[t._v("Are you sure you want to dispatch the job?")])],1)],{command:t.command}),t._v(" "),n("div",{staticClass:"bg-30 px-6 py-3 flex"},[n("div",{staticClass:"ml-auto"},[n("button",{staticClass:"btn text-80 font-normal h-9 px-3 mr-3 btn-link",attrs:{type:"button","data-testid":"cancel-button",dusk:"cancel-dispatch-job-button"},on:{click:function(e){return e.preventDefault(),t.handleClose(e)}}},[t._v(t._s(t.__("Cancel")))]),t._v(" "),n("button",{ref:"confirmButton",staticClass:"btn btn-default btn-primary",attrs:{id:"confirm-dispatch-job-button","data-testid":"confirm-button",type:"submit"}},[t._v("Dispatch")])])])],2)}}],null,!0)})},staticRenderFns:[]}},function(t,e,n){var s=n(0)(n(11),n(12),!1,null,null,null);t.exports=s.exports},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=n(1);e.default={mixins:[s.a],data:function(){return{tasks:[],loading:!1,dispatchJob:null,confirmDispatchJobModal:!1}},mounted:function(){this.fetchTasks()},methods:{canDispatchCommand:function(t){return!!t&&t.includes("Jobs")},openConfirmationModal:function(t){this.dispatchJob=t,this.confirmDispatchJobModal=!0},confirmDispatchJob:function(){var t=this,e=this.dispatchJob;Nova.request().post("/nova-vendor/eagle-developers/nova-scheduled-tasks/dispatch-job",{command:e.command}).then(function(e){t.confirmDispatchJobModal=!1,t.$toasted.show("The job was dispatched!",{type:"success"})}).catch(function(e){t.confirmDispatchJobModal=!1,t.$toasted.show(e.response.data.message,{type:"error"})})},fetchTasks:function(){var t=this;this.loading=!0,Nova.request().get("/nova-vendor/eagle-developers/nova-scheduled-tasks/tasks").then(function(e){t.loading=!1,t.tasks=e.data,setTimeout(t.fetchTasks,6e4)})}}}},function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("heading",{staticClass:"mb-4"},[t._v("\n        Scheduled Tasks\n    ")]),t._v(" "),n("card",{staticClass:"h-auto p-4 mb-4 overflow-scroll"},[t.loading||t.tasks.length?t._e():n("p",[t._v("You do not currently have any scheduled tasks.")]),t._v(" "),t.loading?n("loader",{staticClass:"mb-4"}):t._e(),t._v(" "),!t.loading&&t.tasks.length?n("table",{staticClass:"table w-full"},[n("thead",[n("tr",[n("th",{staticClass:"text-left"},[t._v("Command")]),t._v(" "),n("th",{staticClass:"text-left"},[t._v("Description")]),t._v(" "),n("th",{staticClass:"text-left"},[t._v("Schedule")]),t._v(" "),n("th",{staticClass:"text-left"},[t._v("Expression")]),t._v(" "),n("th",{staticClass:"text-left"},[t._v("Next Run At")]),t._v(" "),n("th",{staticClass:"text-left"},[t._v("Without Overlapping")]),t._v(" "),n("th",{staticClass:"text-left"},[t._v("On One Server")]),t._v(" "),n("th",{staticClass:"text-left"},[t._v("Run In Maintenance Mode")]),t._v(" "),n("th",{staticClass:"text-left"},[t._v("Dispatch")])])]),t._v(" "),n("tbody",t._l(t.tasks,function(e,s){return n("tr",[n("td",[t._v(t._s(e.command))]),t._v(" "),n("td",{staticClass:"py-2"},[t._v(t._s(e.description))]),t._v(" "),n("td",{staticClass:"py-2"},[t._v(t._s(e.humanReadableExpression))]),t._v(" "),n("td",[t._v(t._s(e.expression))]),t._v(" "),n("td",[t._v(t._s(t.formatNextRunAt(e.nextRunAt)))]),t._v(" "),n("td",[t._v(t._s(e.withoutOverlapping?"Yes":"No"))]),t._v(" "),n("td",[t._v(t._s(e.onOneServer?"Yes":"No"))]),t._v(" "),n("td",[t._v(t._s(e.evenInMaintenanceMode?"Yes":"No"))]),t._v(" "),n("td",[n("button",{staticClass:"appearance-none mr-3",class:t.canDispatchCommand(e.command)?"text-70 hover:text-primary":"cursor-default text-40",attrs:{title:"Dispatch",disabled:!t.canDispatchCommand(e.command)},on:{click:function(n){return n.preventDefault(),t.openConfirmationModal(e)}}},[n("icon",{attrs:{type:"play"}})],1)])])}),0)]):t._e(),t._v(" "),n("portal",{attrs:{to:"modals"}},[n("transition",{attrs:{name:"fade"}},[t.confirmDispatchJobModal?n("dispatch-job-modal",{attrs:{command:t.dispatchJob.command},on:{confirm:t.confirmDispatchJob,close:function(e){t.confirmDispatchJobModal=!1}}}):t._e()],1)],1)],1)],1)},staticRenderFns:[]}}]);