webpackJsonp([4],{"1xdo":function(t,e){},"5FIP":function(t,e,i){"use strict";(function(t){var s=i("pFYg");i.n(s);e.a={name:"AddAntistop",data:function(){return{addKeyWord:{channel:[],period:"",keyWord:[""]},channel:[],period:[30,90,180],addBtnType:{color:"primary",isClick:!1},nextBtnType:{color:"info",isClick:!0},fileName:"",batch:!0,verifyKwData:[],multipleSelection:[],channelFilter:[],hotLine:[{describe:"普通",color:"#00ce35",grade:"25%"},{describe:"一般",color:"#00ce35",grade:"50%"},{describe:"高热",color:"#fd9a00",grade:"75%"},{describe:"极热",color:"#fe0000",grade:"100%"}],suitableLine:[{describe:"较难",color:"#fe0002",grade:"25%"},{describe:"有出入",color:"#fc9a03",grade:"50%"},{describe:"很好",color:"#00cd32",grade:"75%"},{describe:"适合",color:"#00cd32",grade:"100%"}]}},methods:{getData:function(){var t=this;this.$axios.post("http://pml.zhihuo.com.cn/api/project/get_channel",this.$qs.stringify({token:document.cookie.match(/token=(.*?)(;|$)/)[1]})).then(function(e){"操作成功"===e.data.msg?t.channel=e.data.data:t.$message.error(e.data.msg),t.channel.map(function(e){t.channelFilter.push({text:e.name,value:e.name})})}).catch(function(e){t.$message.error("错了哦，请检查您的网络连接")})},addKw:function(){this.addKeyWord.keyWord.push(""),t(".periodItem>i").hide()},channelList:function(e,i){var s="",a=e||window.event,n=a.target||a.srcElement;if((s="SPAN"===t(n).prop("tagName")?t(n):t(n).parent()).find("i").toggle(),s.find("i").is(":visible"))this.addKeyWord.channel.push(this.channel[i]);else{var o=this.addKeyWord.channel.indexOf(this.channel[i]);this.addKeyWord.channel.splice(o,1)}this.addKeyWord.channel.length===this.channel.length?t(".allchannel>i").css({display:"block"}):t(".allchannel>i").css({display:"none"})},allchannel:function(e){this.addKeyWord.channel=[];var i="",s=e||window.event,a=s.target||s.srcElement;if((i="SPAN"===t(a).prop("tagName")?t(a):t(a).parent()).find("i").toggle(),i.find("i").is(":visible")){for(var n=0;n<this.channel.length;n++)this.addKeyWord.channel.push(this.channel[n]);t(".channelList>i").css({display:"block"})}else this.addKeyWord.channel=[],t(".channelList>i").css({display:"none"})},periodLong:function(e){var i="",s=e||window.event,a=s.target||s.srcElement;i="SPAN"===t(a).prop("tagName")?t(a):t(a).parent(),t(".periodItem>i").hide(),i.find("i").show(),this.addKeyWord.period=s.target.innerText.slice(0,s.target.innerText.length-1)},kwSub:function(){var t=this,e=!1;if(-1!==this.addKeyWord.keyWord.indexOf("")?this.$alert("提交失败！有关键词未填写!","提示",{confirmButtonText:"确定"}):0===this.addKeyWord.channel.length?this.$alert("提交失败！有渠道未填写!","提示",{confirmButtonText:"确定"}):this.addKeyWord.period?e=!0:this.$alert("提交失败！有周期未填写!","提示",{confirmButtonText:"确定"}),e){this.nextBtnType.color="info",this.nextBtnType.isClick=!0;var i=[],s=[];this.addKeyWord.keyWord.map(function(t){i.push(t)}),this.addKeyWord.channel.map(function(t){s.push(t.id)}),this.$axios.post("http://pml.zhihuo.com.cn/api/project/add_project_2",this.$qs.stringify({token:document.cookie.match(/token=(.*?)(;|$)/)[1],keyword:i.join(),channel:s.join(),days:this.addKeyWord.period.replace(/(^\s*)|(\s*$)/g,""),project_id:parseInt(this.$route.params.id),project_num:this.$route.params.num})).then(function(e){"操作成功"===e.data.msg?(t.$message({message:"关键词添加成功！正在更新关键词列表，请稍后",type:"success"}),t.getKwList(),t.addBtnType.color="info",t.addBtnType.isClick=!0):t.$message.error(e.data.msg)}).catch(function(e){t.$message.error("错了哦，请检查您的网络连接")})}},batFrom:function(){var e=this;if(this.batch){this.nextBtnType.color="info",this.nextBtnType.isClick=!0,this.batch=!1,this.fileName=t("#batFile")[0].files[0].name;var i=t("#batFile")[0].files[0],s=new FormData;s.append("file",i),s.append("token",document.cookie.match(/token=(.*?)(;|$)/)[1]),s.append("project_id",parseInt(this.$route.params.id)),s.append("project_num",this.$route.params.num),this.$axios.post("http://pml.zhihuo.com.cn/api/project/do_excelImport",s).then(function(t){"操作成功"===t.data.msg&&e.getKwList()}).catch(function(t){e.$message.error("错了哦，请检查您的网络连接")})}},style:function(){window.location.href="http://pml.zhihuo.com.cn/upload/style/explain.xlsx"},getKwList:function(){var t=this;this.$axios.post("http://pml.zhihuo.com.cn/api/project/keyword_optimizer",this.$qs.stringify({token:document.cookie.match(/token=(.*?)(;|$)/)[1],project_id:this.$route.params.id}),{timeout:6e4}).then(function(e){"操作成功"===e.data.msg?t.verifyKwData=e.data.data:t.$message.error(e.data.msg),t.nextBtnType.color="primary",t.nextBtnType.isClick=!1})},filterTag:function(t,e){return e.channel_name===t},kwDelete:function(t,e,i){var s=this;this.$axios.post("http://pml.zhihuo.com.cn/api/project/keyproject_del",this.$qs.stringify({token:document.cookie.match(/token=(.*?)(;|$)/)[1],id:e.id})).then(function(e){"操作成功"===e.data.msg?(i.splice(t,1),s.$message({message:"删除成功",type:"success"})):s.$message.error(e.data.msg)}).catch(function(t){s.$message.error("错了哦，请检查您的网络连接")})},handleSelectionChange:function(t){this.multipleSelection=t},nextStep:function(){this.nextBtnType.isClick||0===this.verifyKwData.length?(this.nextBtnType.color="info",this.nextBtnType.isClick=!0,this.$message.error("请添加关键词")):this.$router.push("/ranking/newProject/createProjectThi/"+this.$route.params.id+"/"+this.$route.params.num)}},mounted:function(){this.getData()}}}).call(e,i("7t+N"))},"97OH":function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s={name:"newPjtOne",data:function(){return{firstStepForm:{itemName:"",webSite:"",logofile:""},firstStepRules:{itemName:[{required:!0,message:"请输入项目名称",trigger:"blur"}],webSite:[{required:!0,message:"请输入站点网址",trigger:"blur"},{pattern:/^([hH][tT]{2}[pP]:\/\/|[hH][tT]{2}[pP][sS]:\/\/|www\.)(([A-Za-z0-9-~]+)\.)+([A-Za-z0-9-~\/])+$/,message:"请输入正确的站点网址",trigger:"blur"}]}}},methods:{nextStep:function(t){var e=this;this.$refs[t].validate(function(t){if(!t)return e.$message.error("请填写所有内容"),!1;e.$axios.post("http://pml.zhihuo.com.cn/api/project/add_project_1",e.$qs.stringify({token:document.cookie.match(/token=(.*?)(;|$)/)[1],name:e.firstStepForm.itemName,address:e.firstStepForm.webSite,logo_image:e.firstStepForm.logofile})).then(function(t){"操作成功"===t.data.msg?e.$router.push("/ranking/newProject/addAntistopTwo/"+t.data.data.id+"/"+t.data.data.num):e.$message.error(t.data.msg)}).catch(function(t){e.$message.error(t.data.msg)})})},getImg:function(t){var e=this,i=t.target.files[0],s=new FormData;s.append("file",i),s.append("token",document.cookie.match(/token=(.*?)(;|$)/)[1]),this.$axios.create({withCredentials:!0}).post("http://pml.zhihuo.com.cn/api/common/upload",s).then(function(t){e.firstStepForm.logofile=t.data.data.url,e.$message({message:t.data.msg,type:"success"})}).catch(function(t){})}},mounted:function(){}},a={render:function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{attrs:{id:"newPjtOne"}},[i("div",{staticClass:"conBoxBorder"},[t._m(0),t._v(" "),i("div",{staticClass:"itemBox"},[t._m(1),t._v(" "),i("el-form",{ref:"firstStepForm",staticClass:"demo-ruleForm",attrs:{model:t.firstStepForm,rules:t.firstStepRules,"label-width":"120px"}},[i("el-form-item",{attrs:{label:"项目名称：",prop:"itemName"}},[i("el-input",{attrs:{placeholder:"输入项目名称"},model:{value:t.firstStepForm.itemName,callback:function(e){t.$set(t.firstStepForm,"itemName","string"==typeof e?e.trim():e)},expression:"firstStepForm.itemName"}})],1),t._v(" "),i("el-form-item",{attrs:{label:"站点网址：",prop:"webSite"}},[i("el-input",{attrs:{placeholder:"输入项目名称"},model:{value:t.firstStepForm.webSite,callback:function(e){t.$set(t.firstStepForm,"webSite","string"==typeof e?e.trim():e)},expression:"firstStepForm.webSite"}})],1),t._v(" "),i("el-form-item",{attrs:{label:"logo上传："}},[i("div",{staticClass:"uploadBox"},[i("div",{staticClass:"logo"},[i("img",{attrs:{src:"http://pml.zhihuo.com.cn"+t.firstStepForm.logofile,alt:""}})]),t._v(" "),i("label",{attrs:{for:"itemLogo"}},[i("span",{staticClass:"addlogo"},[t._v("+选择上传")])]),t._v(" "),i("input",{staticStyle:{display:"none"},attrs:{id:"itemLogo",type:"file",accept:"image/gif, image/jpeg"},on:{change:t.getImg}}),t._v(" "),i("span",{staticClass:"hint"},[t._v("*支持格式：jpg、png；建议尺寸：120*120")])])])],1)],1),t._v(" "),i("div",{staticClass:"btnBox"},[i("el-button",{attrs:{type:"primary"},on:{click:function(e){return t.nextStep("firstStepForm")}}},[t._v("下一步")])],1)])])},staticRenderFns:[function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"stepsBox"},[i("ul",{staticClass:"steps"},[i("li",[i("div",{staticClass:"step"},[i("span",{staticClass:"isActive"},[t._v("01")]),t._v(" "),i("p",[t._v("基本信息")])]),t._v(" "),i("div",{staticClass:"stepsLine"})]),t._v(" "),i("li",[i("div",{staticClass:"step"},[i("span",[t._v("02")]),t._v(" "),i("p",[t._v("添加关键词")])]),t._v(" "),i("div",{staticClass:"stepsLine"})]),t._v(" "),i("li",[i("div",{staticClass:"step"},[i("span",[t._v("03")]),t._v(" "),i("p",[t._v("创建项目")])])])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"itemTitle"},[e("i"),this._v(" "),e("h4",[this._v("基本信息")])])}]};var n=i("VU/8")(s,a,!1,function(t){i("FHVw")},"data-v-0d7236fa",null);e.default=n.exports},AU5i:function(t,e){},CQAN:function(t,e){t.exports="data:image/png;base64,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"},FHVw:function(t,e){},Hdf0:function(t,e){},MFnB:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=i("5FIP"),a={render:function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{attrs:{id:"addAntistop"}},[i("div",{staticClass:"conBoxBorder"},[t._m(0),t._v(" "),i("div",{staticClass:"itemBox"},[t._m(1),t._v(" "),i("div",{staticClass:"keyWord"},[t._m(2),t._v(" "),i("div",{staticClass:"keywordRow"},[i("ul",{staticClass:"keyWordList"},t._l(t.addKeyWord.keyWord,function(e,s){return i("li",{key:s},[i("div",{staticClass:"keyWordBox"},[i("input",{directives:[{name:"model",rawName:"v-model.trim",value:t.addKeyWord.keyWord[s],expression:"addKeyWord.keyWord[index]",modifiers:{trim:!0}}],attrs:{type:"text"},domProps:{value:t.addKeyWord.keyWord[s]},on:{input:function(e){e.target.composing||t.$set(t.addKeyWord.keyWord,s,e.target.value.trim())},blur:function(e){return t.$forceUpdate()}}})])])}),0),t._v(" "),i("div",{staticClass:"channelBox"},[i("span",{staticClass:"channelBtnList allchannel",on:{click:function(e){return t.allchannel(e)}}},[t._v("\n                全选\n                "),i("i",{staticClass:"el-icon-check"})]),t._v(" "),t._l(t.channel,function(e,s){return[i("span",{staticClass:"channelBtnList channelList",on:{click:function(e){return t.channelList(e,s)}}},[t._v("\n                  "+t._s(e.name)+"\n                  "),i("i",{staticClass:"el-icon-check"})])]})],2)]),t._v(" "),i("div",{staticClass:"addInput"},[i("span",{on:{click:t.addKw}},[t._v("+添加关键词")])]),t._v(" "),i("div",{staticClass:"periodBox"},[i("h6",[t._v("*优化周期")]),t._v(" "),i("div",{on:{click:function(e){return t.periodLong(e)}}},t._l(t.period,function(e){return i("span",{staticClass:"channelBtnList periodItem"},[t._v("\n              "+t._s(e)+"天\n              "),i("i",{staticClass:"el-icon-check"})])}),0)])]),t._v(" "),i("el-button",{staticClass:"keyWordSub",attrs:{type:t.addBtnType.color,disabled:t.addBtnType.isClick},on:{click:t.kwSub}},[t._v("提交\n      ")])],1),t._v(" "),i("div",{staticClass:"itemBox"},[t._m(3),t._v(" "),i("div",{staticClass:"batchBody"},[i("div",{staticClass:"batDet"},[i("span",[t._v(t._s(t.fileName))]),t._v(" "),i("input",{attrs:{id:"batFile",type:"file",accept:".xls,.xlsx"},on:{change:t.batFrom}}),t._v(" "),t.batch?i("label",{attrs:{for:"batFile"}},[t._v("+批量导入")]):i("label",{staticClass:"forbidden"},[t._v("+批量导入")])]),t._v(" "),i("p",[t._v("注：支持扩展名：.xls、.xlsx，请先下载\n          "),i("span",{on:{click:t.style}},[t._v("上传样式")]),t._v("\n          ，务必按照样例格式操作。\n        ")])])]),t._v(" "),i("div",{staticClass:"itemBox"},[t._m(4),t._v(" "),i("el-table",{ref:"multipleTable",staticStyle:{width:"100%"},attrs:{data:t.verifyKwData,"tooltip-effect":"dark","max-height":"350"},on:{"selection-change":t.handleSelectionChange}},[i("el-table-column",{attrs:{type:"selection",width:"55"}}),t._v(" "),i("el-table-column",{attrs:{prop:"keyword_name",label:"关键词","show-overflow-tooltip":""}}),t._v(" "),i("el-table-column",{attrs:{prop:"channel_name",label:"渠道选择",filters:t.channelFilter,"filter-method":t.filterTag,"filter-placement":"bottom-end"}}),t._v(" "),i("el-table-column",{attrs:{prop:"days",label:"优化周期","show-overflow-tooltip":""}}),t._v(" "),i("el-table-column",{attrs:{prop:"price",label:"单价","show-overflow-tooltip":""}}),t._v(" "),i("el-table-column",{attrs:{prop:"amount",label:"总价","show-overflow-tooltip":""}}),t._v(" "),i("el-table-column",{attrs:{width:"200",label:"热度","show-overflow-tooltip":""},scopedSlots:t._u([{key:"default",fn:function(e){return["普通"===e.row.heat?i("div",{style:"color:"+t.hotLine[0].color},[i("div",{staticClass:"progress",style:"border-color:"+t.hotLine[0].color},[i("i",{style:"background-color: "+t.hotLine[0].color+";width:"+t.hotLine[0].grade})]),t._v("\n              "+t._s(t.hotLine[0].describe)+"\n            ")]):t._e(),t._v(" "),"一般"===e.row.heat?i("div",{style:"color:"+t.hotLine[1].color},[i("div",{staticClass:"progress",style:"border-color:"+t.hotLine[1].color},[i("i",{style:"background-color: "+t.hotLine[1].color+";width:"+t.hotLine[1].grade})]),t._v("\n              "+t._s(t.hotLine[1].describe)+"\n            ")]):t._e(),t._v(" "),"高热"===e.row.heat?i("div",{style:"color:"+t.hotLine[2].color},[i("div",{staticClass:"progress",style:"border-color:"+t.hotLine[2].color},[i("i",{style:"background-color: "+t.hotLine[2].color+";width:"+t.hotLine[2].grade})]),t._v("\n              "+t._s(t.hotLine[2].describe)+"\n            ")]):t._e(),t._v(" "),"极热"===e.row.heat?i("div",{style:"color:"+t.hotLine[3].color},[i("div",{staticClass:"progress",style:"border-color:"+t.hotLine[3].color},[i("i",{style:"background-color: "+t.hotLine[3].color+";width:"+t.hotLine[3].grade})]),t._v("\n              "+t._s(t.hotLine[3].describe)+"\n            ")]):t._e()]}}])}),t._v(" "),i("el-table-column",{attrs:{width:"200",label:"合适度","show-overflow-tooltip":""},scopedSlots:t._u([{key:"default",fn:function(e){return["较难"===e.row.conformity?i("div",{style:"color:"+t.suitableLine[0].color},[i("div",{staticClass:"progress",style:"border-color:"+t.suitableLine[0].color},[i("i",{style:"background-color: "+t.suitableLine[0].color+";width:"+t.suitableLine[0].grade})]),t._v("\n              "+t._s(t.suitableLine[0].describe)+"\n            ")]):t._e(),t._v(" "),"有出入"===e.row.conformity?i("div",{style:"color:"+t.suitableLine[1].color},[i("div",{staticClass:"progress",style:"border-color:"+t.suitableLine[1].color},[i("i",{style:"background-color: "+t.suitableLine[1].color+";width:"+t.suitableLine[1].grade})]),t._v("\n              "+t._s(t.suitableLine[1].describe)+"\n            ")]):t._e(),t._v(" "),"很好"===e.row.conformity?i("div",{style:"color:"+t.suitableLine[2].color},[i("div",{staticClass:"progress",style:"border-color:"+t.suitableLine[2].color},[i("i",{style:"background-color: "+t.suitableLine[2].color+";width:"+t.suitableLine[2].grade})]),t._v("\n              "+t._s(t.suitableLine[2].describe)+"\n            ")]):t._e(),t._v(" "),"合适"===e.row.conformity?i("div",{style:"color:"+t.suitableLine[3].color},[i("div",{staticClass:"progress",style:"border-color:"+t.suitableLine[3].color},[i("i",{style:"background-color: "+t.suitableLine[3].color+";width:"+t.suitableLine[3].grade})]),t._v("\n              "+t._s(t.suitableLine[3].describe)+"\n            ")]):t._e()]}}])}),t._v(" "),i("el-table-column",{attrs:{fixed:"right",label:"操作",width:"100"},scopedSlots:t._u([{key:"default",fn:function(e){return[i("el-button",{attrs:{type:"text",size:"small"},nativeOn:{click:function(i){return i.preventDefault(),t.kwDelete(e.$index,e.row,t.verifyKwData)}}},[t._v("\n              移除\n            ")])]}}])})],1)],1),t._v(" "),i("div",{staticClass:"btnBox"},[i("router-link",{attrs:{to:"/ranking/newProject/createProjectThi"}}),t._v(" "),i("el-button",{staticClass:"keyWordSub",attrs:{type:"primary",type:t.nextBtnType.color,disabled:t.nextBtnType.isClick},on:{click:t.nextStep}},[t._v("下一步")])],1)])])},staticRenderFns:[function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"stepsBox"},[i("ul",{staticClass:"steps"},[i("li",[i("div",{staticClass:"step"},[i("span",[t._v("01")]),t._v(" "),i("p",[t._v("基本信息")])]),t._v(" "),i("div",{staticClass:"stepsLine"})]),t._v(" "),i("li",[i("div",{staticClass:"step"},[i("span",{staticClass:"isActive"},[t._v("02")]),t._v(" "),i("p",[t._v("添加关键词")])]),t._v(" "),i("div",{staticClass:"stepsLine"})]),t._v(" "),i("li",[i("div",{staticClass:"step"},[i("span",[t._v("03")]),t._v(" "),i("p",[t._v("创建项目")])])])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"itemTitle"},[e("i"),this._v(" "),e("h4",[this._v("手动添加关键词")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"keyWordtitle"},[e("h6",[this._v("*关键词：")]),this._v(" "),e("h6",[this._v("*渠道选择：")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"itemTitle"},[e("i"),this._v(" "),e("h4",[this._v("批量导入关键词")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"itemTitle"},[e("i"),this._v(" "),e("h4",[this._v("关键词确认")])])}]};var n=function(t){i("Hdf0")},o=i("VU/8")(s.a,a,!1,n,"data-v-94898c02",null);e.default=o.exports},"OP/K":function(t,e){},b8GY:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s={render:function(){var t=this.$createElement;return(this._self._c||t)("router-view")},staticRenderFns:[]};var a=i("VU/8")({name:"IndexNewProject"},s,!1,function(t){i("1xdo")},"data-v-8df90988",null);e.default=a.exports},jqFV:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s={name:"CreateProjectThi",data:function(){return{titleData:{},payable:"0",discount:!1,discountPre:!1,discountDialog:!1,discountData:[],discountDataNum:[],discountID:"",discountMoney:"0",practical:"",remainingManey:"",enough:!1,clause:!1,clausePre:!1,clauseDialog:!1,beginPay:!1,payBtnType:{color:"primary",isClick:!0}}},methods:{getData:function(){var t=this;this.$axios.post("http://pml.zhihuo.com.cn/api/project/add_project_3",this.$qs.stringify({token:document.cookie.match(/token=(.*?)(;|$)/)[1],project_num:this.$route.params.num})).then(function(e){t.titleData=e.data.data.data,t.titleData.amount.amount&&(t.payable=t.titleData.amount.amount),t.remainingManey=t.titleData.usable_money.money,e.data.data.coupon.map(function(e){if("1"!==e.status){switch(e.pitch=!1,e.type){case"0":e.type="注册赠送";break;case"1":e.type="满减";break;case"2":e.type="折扣";break;case"3":e.type="固定金额"}t.discountData.push(e)}})}).catch(function(e){t.$message.error("错了哦，请检查您的网络连接")})},discountList:function(){this.discountPre?this.discount=!0:this.discount=!1,this.discountDialog=!0},addDis:function(){this.discountID?this.discountPre=!0:this.discountPre=!1,this.discountDialog=!1},selectDiscount:function(t){this.discountData[t].pitch?(this.discountData[t].pitch=!1,this.discountID="",this.discountMoney="0"):(this.discountData.map(function(t){t.pitch=!1}),this.discountData[t].pitch=!0,this.discountID=this.discountData[t].coupon_id,this.discountMoney=this.discountData[t].price),this.$forceUpdate()},protocolCon:function(){this.clausePre?this.clause=!0:this.clause=!1,this.clauseDialog=!0},protocolAgree:function(){this.clause=!0,this.clausePre=!0,this.clauseDialog=!1},protocolDisagree:function(){this.clauseDialog=!1,this.clause=!1,this.clausePre=!1},isPay:function(){this.clause?(parseInt(this.remainingManey)>=parseInt(this.practical)?(this.enough=!1,this.payBtnType.color="primary",this.payBtnType.isClick=!1):(this.payBtnType.color="info",this.payBtnType.isClick=!0,this.enough=!0),this.beginPay=!0):this.$alert("请同意《排名啦服务协议》","提示",{confirmButtonText:"确定"})},confirmPay:function(){var t=this;this.enough||this.$axios.post("http://pml.zhihuo.com.cn/api/project/pay_project",this.$qs.stringify({token:document.cookie.match(/token=(.*?)(;|$)/)[1],project_num:this.$route.params.num,amount:this.payable,coupon_id:this.discountID})).then(function(e){"支付成功"===e.data.msg?(t.$message({message:e.data.msg,type:"success"}),t.reptile()):t.$message.error(e.data.msg)}).catch(function(e){t.$message.error("错了哦，请检查您的网络连接")})},reptile:function(){var t=this;this.$axios.post("http://pml.zhihuo.com.cn/api/project/pay_king",this.$qs.stringify({token:document.cookie.match(/token=(.*?)(;|$)/)[1],project_id:this.$route.params.id})).then(function(e){t.$router.push("/ranking/newProject/paySuccess")}).catch(function(e){t.$message.error("错了哦，请检查您的网络连接")})}},mounted:function(){this.getData()},updated:function(){var t=this;this.discountDialog||this.discountData.map(function(e){e.pitch?t.discount=!0:t.discount=!1}),this.discount?parseInt(this.discountMoney)>parseInt(this.payable)?this.practical="0":this.practical=this.payable-this.discountMoney:this.practical=this.payable}},a={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{attrs:{id:"createProjectThi"}},[s("div",{staticClass:"conBoxBorder"},[t._m(0),t._v(" "),s("div",{staticClass:"itemBox"},[t._m(1),t._v(" "),s("div",{staticClass:"pjctDtlBox"},[s("div",{staticClass:"logoImg"},[t.titleData.logo_image?s("img",{attrs:{src:"http://pml.zhihuo.com.cn"+t.titleData.logo_image,alt:""}}):s("img",{attrs:{src:i("CQAN"),alt:""}})]),t._v(" "),s("ul",{staticClass:"pjctDtl"},[s("li",[s("h6",[t._v("项目编号：")]),t._v(" "),s("el-tooltip",{staticClass:"item",attrs:{effect:"dark",content:t.titleData.num,placement:"top"}},[s("span",[t._v(t._s(t.titleData.num))])])],1),t._v(" "),s("li",[s("h6",[t._v("项目名称：")]),t._v(" "),s("span",[t._v(t._s(t.titleData.name))])]),t._v(" "),s("li",[s("h6",[t._v("站点网址：")]),t._v(" "),s("span",[t._v(t._s(t.titleData.address))])]),t._v(" "),s("li",[s("h6",[t._v("优化渠道：")]),t._v(" "),s("span",[t._v(t._s(t.titleData.channel_num))])]),t._v(" "),s("li",[s("h6",[t._v("关键词数：")]),t._v(" "),s("span",[t._v(t._s(t.titleData.keyword_num))])]),t._v(" "),s("li",[s("h6",[t._v("优化周期：")]),t._v(" "),s("span",[t._v(t._s(t.titleData.days)+"天")])]),t._v(" "),s("li",[s("h6",[t._v("下单时间：")]),t._v(" "),s("span",[t._v(t._s(t.titleData.create_time))])])])]),t._v(" "),s("div",{staticClass:"discountBox"},[s("div",{staticClass:"leftBox"},[s("p",[t._v("*服务费将从账户余额中扣除，请保证有足够的金额")]),t._v(" "),s("el-checkbox",{on:{change:t.discountList},model:{value:t.discount,callback:function(e){t.discount=e},expression:"discount"}},[t._v("使用优惠券（"),s("i",[t._v(t._s(t.discountData.length))]),t._v("张可用）\n          ")]),t._v(" "),s("el-dialog",{attrs:{title:"优惠券",visible:t.discountDialog,width:"30%"},on:{"update:visible":function(e){t.discountDialog=e}}},[s("ul",{staticClass:"discountListBox"},t._l(t.discountData,function(e,i){return"0"===e.status?s("li",{on:{click:function(e){return t.selectDiscount(i)}}},[s("h6",[t._v(t._s(e.type))]),t._v(" "),s("div",[s("span",[t._v("金额：")]),t._v(" "),s("b",[t._v("￥"+t._s(e.price))])]),t._v(" "),s("p",[t._v("有效期至"+t._s(e.endtime))]),t._v(" "),s("span",[e.pitch?s("i",{staticClass:"el-icon-success"}):t._e()])]):t._e()}),0),t._v(" "),s("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[s("el-button",{attrs:{type:"primary"},on:{click:t.addDis}},[t._v("确 定")])],1)])],1),t._v(" "),s("ul",{staticClass:"paymentBox"},[s("li",[s("h6",[t._v("应付金额：")]),s("span",[t._v("￥"+t._s(t.payable))])]),t._v(" "),s("li",[s("h6",[t._v("优惠金额：")]),s("span",[t._v("￥"+t._s(t.discountMoney))])]),t._v(" "),s("li",[s("h6",[t._v("实付金额：")]),s("span",[t._v("￥"+t._s(t.practical))])]),t._v(" "),s("li",[s("el-checkbox",{on:{change:t.protocolCon},model:{value:t.clause,callback:function(e){t.clause=e},expression:"clause"}},[t._v("同意《排名啦服务协议》")]),t._v(" "),s("el-dialog",{staticStyle:{"text-align":"left"},attrs:{title:"优惠券",visible:t.clauseDialog,width:"30%"},on:{"update:visible":function(e){t.clauseDialog=e}}},[s("div",[t._v("服务协议服务协议服务协议服务协议服务协议服务协议")]),t._v(" "),s("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[s("el-button",{on:{click:t.protocolDisagree}},[t._v("取 消")]),t._v(" "),s("el-button",{attrs:{type:"primary"},on:{click:t.protocolAgree}},[t._v("确 定")])],1)])],1),t._v(" "),t.beginPay?t._e():s("li",[s("el-button",{staticClass:"payBtn",attrs:{type:"primary"},on:{click:t.isPay}},[t._v("支付")])],1)])]),t._v(" "),t.beginPay?[s("div",{staticClass:"hintBox"},[s("span",[t._v("可用余额："),s("i",[t._v("￥"+t._s(t.remainingManey))])]),t._v(" "),s("span",[t._v("本次需要支付："),s("i",[t._v("￥"+t._s(t.practical))])]),t._v(" "),s("el-button",{staticStyle:{float:"right"},attrs:{type:t.payBtnType.color,disabled:t.payBtnType.isClick},on:{click:t.confirmPay}},[t._v("\n            确定\n          ")])],1),t._v(" "),t.enough?s("div",{staticClass:"hintBox"},[t._v("\n          您的余额不足：\n          "),s("router-link",{attrs:{to:"/financialCenter/chargeCenter"}},[t._v("点击这里充值")])],1):t._e()]:t._e(),t._v(" "),t._m(2)],2)])])},staticRenderFns:[function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"stepsBox"},[i("ul",{staticClass:"steps"},[i("li",[i("div",{staticClass:"step"},[i("span",[t._v("01")]),t._v(" "),i("p",[t._v("基本信息")])]),t._v(" "),i("div",{staticClass:"stepsLine"})]),t._v(" "),i("li",[i("div",{staticClass:"step"},[i("span",[t._v("02")]),t._v(" "),i("p",[t._v("添加关键词")])]),t._v(" "),i("div",{staticClass:"stepsLine"})]),t._v(" "),i("li",[i("div",{staticClass:"step"},[i("span",{staticClass:"isActive"},[t._v("03")]),t._v(" "),i("p",[t._v("创建项目")])])])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"itemTitle"},[e("i"),this._v(" "),e("h4",[this._v("订单支付")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"attention"},[e("h5",[e("i",{staticClass:"el-icon-warning"}),this._v("注意事项：")]),this._v(" "),e("p",[this._v("如果该页面意外关闭，可在充值完成后，到项目列表>>订单管理中找到该订单进行支付。")])])}]};var n=i("VU/8")(s,a,!1,function(t){i("AU5i")},"data-v-6c01763c",null);e.default=n.exports},uBUY:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s={name:"PaySuccess",data:function(){return{time:5,type:""}},methods:{jump:function(){clearInterval(this.type),this.$router.push("/")}},mounted:function(){var t=this;this.type=setInterval(function(){t.time--,0===t.time&&(clearInterval(t.type),t.$router.push("/"))},1e3)},destroyed:function(){clearInterval(this.type)}},a={render:function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{attrs:{id:"paySuccess"}},[i("div",{staticClass:"conBoxBorder"},[t._m(0),t._v(" "),i("div",{staticClass:"content"},[i("i",{staticClass:"el-icon-success"}),t._v(" "),i("div",{staticClass:"txt"},[i("h3",[t._v("恭喜您，支付成功！")]),t._v(" "),i("p",[t._v("项目已启动，可前往项目列表>>执行项目中管理项目")]),t._v(" "),i("p",[t._v(t._s(t.time)+"s 后自动跳转至后台首页")]),t._v(" "),i("p",[t._v("不等了，"),i("span",{on:{click:t.jump}},[t._v("点击跳转")])])])])])])},staticRenderFns:[function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"stepsBox"},[i("ul",{staticClass:"steps"},[i("li",[i("div",{staticClass:"step"},[i("span",[t._v("01")]),t._v(" "),i("p",[t._v("基本信息")])]),t._v(" "),i("div",{staticClass:"stepsLine"})]),t._v(" "),i("li",[i("div",{staticClass:"step"},[i("span",[t._v("02")]),t._v(" "),i("p",[t._v("添加关键词")])]),t._v(" "),i("div",{staticClass:"stepsLine"})]),t._v(" "),i("li",[i("div",{staticClass:"step"},[i("span",{staticClass:"isActive"},[t._v("03")]),t._v(" "),i("p",[t._v("创建项目")])])])])])}]};var n=i("VU/8")(s,a,!1,function(t){i("OP/K")},"data-v-23a0d625",null);e.default=n.exports}});