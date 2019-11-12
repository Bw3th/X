<template>
    <div>
        <div class="update_box" v-for="(item,i) in this.data" :key="i">
            <div class="margin-bottom-10" style="overflow:hidden;margin-bottom:10px;">
            <div v-show="isRole()" class="btn-wrap">
                <Button type="primary" @click="newUser" icon="ios-add-circle-outline">新增</Button>
            </div>
            <div id="causes">
                {{item.cause_name}}
            </div>
            <div class="search-wrap"></div>
            </div>
            <Table :loading="loading" :columns="column" :data="item.data">
            
            </Table>
            <div class="allbox">
            <span class="users">付款人数：{{item.sum.people}}</span>
            <span class="moneys">金额总数：{{item.sum.cost}}</span>
            </div>
            <Drawer title="新增" :width="700" :closable="true" v-model="showAdd">
            <add @saved="saved" :value="form"></add>
            </Drawer>
            <Drawer title="编辑" :width="700" :closable="true" v-model="showMoney">
            <money @saved="saved" :value="form"></money>
            </Drawer>
            <Drawer title="编辑" :width="700" :closable="true" v-model="showEditor">
            <edit @saved="saved" :value="form"></edit>
            </Drawer>
            <Drawer title="编辑" :width="700" :closable="true" v-model="showStatus">
            <status @saved="saved" :value="form"></status>
            </Drawer>
            <Drawer title="编辑" :width="700" :closable="true" v-model="showCharge">
            <charge @saved="saved" :value="form"></charge>
            </Drawer>
        </div>
    </div>
</template>

<script>
/* eslint-disable */
import axios from "@/libs/api.request";
import edit from "./payer-edit";
import add from "./payer-add";
import money from "./payer-money";
import status from "./payer-status";
import charge from "./payer-charge";
export default {
  name: "",
  components: {
    edit,
    add,
    money,
    status,
    charge
  },
  props: {
    sex: {
      type: Number,
      default: 0
    } 
  },
  data() {
    return {
      flag:false,
      loading: false,
      showAdd:false,
      showEditor: false,
      showMoney: false,
      showStatus: false,
      showCharge: false,
      cause_id:'',
      cause_name:'',
      cause_status:'',
      form: {},
      sum:{},
      column: [
        {
          title: "名字",
          key: "name",
          width: 80,
        },
        {
          title: "性别",
          key: "sexs",
          width: 60,
          align: "center",
        },
        {
          title: "联系方式",
          key: "mobile",
          width:110,
        },
        {
          title: "身份证",
          key: "IDcard",
          width: 158,
        },
        {
          title: "银行卡号",
          key: "bank_num",
          width: 175,
        },
        {
          title: "开户行",
          key: "opening_bank"
        },
        {
          title: "金额",
          key: "cost",
          width: 80,
        },
        {
          title: "备注",
          key: "remarks"
        },
        {
          type:'html',
          title: "状态",
          key: "m_status",
          width: 150
        },
        {
          title: "操作",
          key: "action",
          align: "center",
          width: 150,
          render: (h, params) => {
            return h("div", [
              h(
                "a",
                {
                  class:'admin_show finance_show',
                  style: {
                    marginRight: "5px"
                  },
                  on: {
                    click: () => {
                      this.handleEdit(params.row);
                    }
                  }
                },
                "退回"
              ),
              h(
                "a",
                {
                  class:'role_show',
                  style: {
                    marginRight: "5px"
                  },
                  on: {
                    click: () => {
                      this.changeMoney(params.row);
                    }
                  }
                },
                "修改金额"
              ),
              h(
                "a",
                {
                  class:'role_show',
                  style: {
                    marginRight: "5px"
                  },
                  on: {
                    click: () => {
                      this.handleRemove(params.row);
                    }
                  }
                },
                "删除"
              ),
              h(
                "a",
                {
                  class:'admin_show',
                  style: {
                    marginRight: "5px"
                  },
                  on: {
                    click: () => {
                      this.handleStatus(params.row);
                    }
                  }
                },
                "支付完成"
              ),
              h(
                "a",
                {
                  class:'ad_show',
                  style: {
                    marginRight: "5px"
                  },
                  on: {
                    click: () => {
                      this.changeCharge(params.row);
                    }
                  }
                },
                "更新账户"
              ),
              h(
                "a",
                {
                  class:'finance_show',
                  style: {
                    marginRight: "5px"
                  },
                  on: {
                    click: () => {
                      this.handleStatus(params.row);
                    }
                  }
                },
                "提交支付"
              )
            ]);
          }
        }
      ],
      data: [],
      pagination: {},
      page: 1
    };
  },
  methods: {
    newUser() {
      this.showAdd = true;
      this.form = { name:'',causeId:this.cause_id, };
    },
    saved() {
      this.showEditor = false;
      this.showAdd = false;
      this.showMoney = false;
      this.showStatus = false,
      this.showCharge = false,
      this.getData();
    },
    getData() {
      axios
        .request({
          method: "get",
          url: "api/cost/alupdate/"+'1',
          params: {
            page:this.page
          }
        })
        .then(res => {

          this.data = res.data.successful;
          
        });
    },
    handleRemove(row) {
      this.$Modal.confirm({
        title: "确认删除",
        content: "<p>确认删除该条记录</p>",
        onOk: () => {
          axios
            .request({
              method: "delete",
              url: "api/cost/charge/" + row.id
            })
            .then(res => {
              this.getData();
            });
        },
        onCancel: () => {}
      });
    },
    handleStatus(row) {
      this.$Modal.confirm({
        title: "确认状态",
        content: "<p>确认更改该条记录</p>",
        onOk: () => {
          axios
            .request({
              method: "put",
              url: "api/cost/status/" + row.id
            })
            .then(res => {
              this.getData();
            });
        },
        onCancel: () => {}
      });
    },
    isRole() {
      axios
        .request({
          method: "get",
          url: "api/cost/memberinfo",
          params: {
            page:this.page
          }
        })
        .then(res => {
            let role = ['ad','operate'];
            let roles = ['ad','operate'];
            for (var v = 0; v < role.length; v++) {
                if (role[v] == res.data.successful) {
                    let show = document.querySelectorAll('.role_show');
                    for(var i=0;i<show.length;i++){
                        show[i].style.display='inline';
                    }
                    break;
                }
            }
            if(res.data.successful == 'finance'){
              let show = document.querySelectorAll('.finance_show');
                for(var i=0;i<show.length;i++){
                    show[i].style.display='inline';
                }
            }
            if(res.data.successful == 'admin'){
              let show = document.querySelectorAll('.admin_show');
                for(var i=0;i<show.length;i++){
                    show[i].style.display='inline';
                }
            }
            if(res.data.successful == 'ad' || res.data.successful == 'operate'){
                
                let show = document.querySelectorAll('.ad_show');
                for(var i=0;i<show.length;i++){
                    show[i].style.display='inline';
                }
            }  
        });
        return this.flag;
    },
    handleEdit(data) {
      this.form = data;
      this.showEditor = true;
    },
    changeMoney(data) {
      this.form = data;
      this.showMoney = true;
    },
    changeStatus(data) {
      this.form = data;
      this.showStatus = true;
    },
    changeCharge(data) {
      if(data.status == '2' || data.status == '3'){
        this.form = data;
        this.showCharge = true;
      }else{
        alert('账户无需修改')
      }
      
    },
    changePage(page) {
      this.page = page;
      this.getData();
    }
  },
  created() {
       this.cause_id = this.$route.query.id;
  },
  mounted() {
    this.getData();
  }
};
</script>

<style>
#causes{
    width: 100%;
    text-align:center;
    font-size: 20px;
    color:#2D8CF0;
    font-weight: bold;
}
.role_show{
    display: none;
}
.allbox{
    text-align: center;
    height: 48px;
    border: 1px solid #DCDEE2;
    border-top: 0px;
    line-height: 48px;
    background-color: #fff;
}
.users{
  margin-right: 100px;
  font-size: 14px
}
.moneys{
  margin-left: 40px;
  font-size: 14px;
}
.finance_show{
  display: none;
}
.ad_show{
  display: none;
}
.admin_show{
  display: none;
}
.update_box{
    margin-bottom: 50px;
}
</style>