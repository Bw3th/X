<template>
  <div>
    <div class="margin-bottom-10" style="overflow:hidden;margin-bottom:10px;">
      <div class="btn-wrap search_box">
        <Button v-show="isRole()" type="primary" @click="newUser" icon="ios-add-circle-outline">新增</Button>
        <!-- <input v-model="Fullname" class="search_input" type="text" placeholder="请输入事由名称"><Button class="search_button" type="primary" icon="ios-search" @click="searchData()"></Button> -->
        <Button type="primary" @click="payee_updated" icon="ios-add-circle-outline" class="finance_show admin_show">待处理账户</Button>
        <Button type="primary" @click="payee_return" icon="ios-add-circle-outline" class="ad_show alreturn">已退回账户</Button>
        <i-input  v-model="Fullname" class="search_input" placeholder="请输入事由名称">
          <i-button slot="append" icon="ios-search" @click.native="searchData()"></i-button>
        </i-input>

        <i-input  v-model="username" class="search_inputs" placeholder="请输入退回账户全名或身份证号码">
          <i-button slot="append" icon="ios-search" @click.native="searchDatas()"></i-button>
        </i-input>
      </div>
      <div class="search-wrap"></div>
    </div>
    <Table :loading="loading" :columns="column" :data="data">
      <Page
        style="margin-left:20px;"
        :total="pagination.total"
        size="small"
        show-total
        show-elevator
        :page-size="pagination.perPage"
        @on-change="changePage"
        slot="footer"
      ></Page>
    </Table>

    <Drawer title="编辑" :width="500" :closable="true" v-model="showEditor">
      <edit @saved="saved" :value="form"></edit>
    </Drawer>
  </div>
</template>

<script>
/* eslint-disable */
import axios from "@/libs/api.request";
import edit from "./payment-edit";
export default {
  name: "",
  components: {
    edit
  },
  props: {
    type: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      loading: false,
      showEditor: false,
      Fullname:'',
      username:'',
      form: {},
      column: [ 
        {
          title: "编号",
          key: "id",
          width:60,
        },
        {
          type:'html',
          title: "付款事由",
          key: "cause_name"
        },
        {
          title: "付款类型",
          key: "tag"
        },
        {
          title: "活动时间",
          key: "begin_time",
          sortable: true
        },
        {
          title: "支付时间",
          key: "pay_time"
        },
        {
          title: "支付金额",
          key: "cost"
        },
        {
          type:'html',
          title: "最终状态",
          key: "finals_status"
        },
        {
          title: "操作",
          key: "action",
          align: "center",
          width: 200,
          render: (h, params) => {
            return h("div", [
              h(
                "a",
                {
                  class:'role_show',
                  style: {
                    marginRight: "5px"
                  },
                  on: {
                    click: () => {
                      this.handleEdit(params.row);
                    }
                  }
                },
                "编辑"
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
                  style: {
                    marginRight: "5px"
                  },
                  on: {
                    click: () => {
                      this.mlist(params.row);
                    }
                  }
                },
                "支付详情"
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
      this.showEditor = true;
      this.form = { final_status:1 };
    },
    saved() {
      this.showEditor = false;
      this.getData();
    },
    getData() {
      axios
        .request({
          method: "get",
          url: "api/cost/consultations",
          params: {
            page:this.page
          }
        })
        .then(res => {
          this.data = res.data.data;
          this.pagination = res.data.pagination;
        });
    },
    getDatas() {
      axios
        .request({
          method: "get",
          url: "api/cost/memberinfo",
          params: {
            page:this.page
          }
        })
        .then(res => {
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
              url: "api/cost/consultations/" + row.id
            })
            .then(res => {
              this.getData();
            });
        },
        onCancel: () => {}
      });
    },
    handleEdit(data) {
      this.form = data;
      this.showEditor = true;
    },
    changePage(page) {
      this.page = page;
      this.getData();
    },
    mlist(row) {

        this.$router.push({ 
        path:'/payer-list',
        query:{
          id : row.id
        }
      })
    },
    payee_updated() {
      this.$router.push({ 
        path:'/payer-updated',
      })
    },
    payee_return() {
      this.$router.push({ 
        path:'/payer-return',
      })
    },
    searchData() {
      let method = "GET";
      let url = "api/cost/msearchs/";
          url += this.Fullname?this.Fullname:0;
      axios
        .request({
          method: method,
          url: url
        })
        .then(res => {
          this.data = res.data.data;
          this.pagination = res.data.pagination;
        });
    },
    searchDatas() {
      let method = "GET";
      let url = "api/cost/usearchs/";
          url += this.username?this.username:0;
      axios
        .request({
          method: method,
          url: url
        })
        .then(res => {
          this.data = res.data.data;
          this.pagination = res.data.pagination;
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
                    this.flag = true;
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
                let seainput = document.querySelector('.search_input');
                seainput.style.left='225px'
                for(var i=0;i<show.length;i++){
                    show[i].style.display='inline';
                }
            }  
        });
        return this.flag;
    },
  },
  mounted() {
    this.getData();
    this.getDatas();
  }
};
</script>

<style >
.search_box{
  position: relative;
}
.search_input{
  position: absolute;
  margin-left: 20px;
  top: 0px;
  left: 120px;
  height: 31.5px;
  width: 200px;
  /* border-right: 0px; */
  /* border-bottom: 1px solid black; */
}
.search_inputs{
  position: absolute;
  margin-left: 20px;
  top: 0px;
  left: 455px;
  height: 31.5px;
  width: 300px;
  /* border-right: 0px; */
  /* border-bottom: 1px solid black; */
}
.search_button{
  position: absolute;
  left: 240px;
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
.role_show{
  display: none;
}
.alreturn{
  margin: 0 30px;
}
</style>
