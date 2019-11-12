<template>
  <div>
    <div class="margin-bottom-10" style="overflow:hidden;margin-bottom:10px;">
      <div class="btn-wrap search_box">
        <Button type="primary" @click="newUser" icon="ios-add-circle-outline">新增</Button>

          <i-input  v-model="Fullname" class="search_input" placeholder="请输入收款人姓名">
            <i-button slot="append" icon="ios-search" @click.native="searchData()"></i-button>
          </i-input>
        <select class="search_select"  v-model="hospital"  @change="searchDatas()">
          <option value="">请选择单位</option>
            <option v-for="(item,i) in this.companys" :value="item.id" :key="i">{{ item.hospital_name }}
            </option>
          </select>
      </div>
      <div class="search-wrap"></div>
    </div>
    <Table :loading="loading" :columns="column" :data="data">
      <Page
        :total="pagination.total"
        size="small"
        show-total
        show-elevator
        :page-size="pagination.perPage"
        @on-change="changePage"
        slot="footer"
        style="margin-left:20px;"
      ></Page>
    </Table>

    <Drawer title="编辑" :width="600" :closable="true" v-model="showEditor">
      <edit @saved="saved" :value="form"></edit>
    </Drawer>
    <Drawer title="编辑" :width="600" :closable="true" v-model="showAddBank">
      <add @saved="saved" :value="form"></add>
    </Drawer>
  </div>
</template>

<script>
/* eslint-disable */
import axios from "@/libs/api.request";
import edit from "./member-edit";
import add from "./member-addbank";
export default {
  name: "",
  components: {
    edit,add
  },
  props: {
    sex: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      loading: false,
      showEditor: false,
      showAddBank:false,
      form: {},
      companys:{},
      hospital:'',
      Fullname:'',
      column: [
        {
          title: "名字",
          key: "name",
          width: 100,
        },
        {
          title: "联系方式",
          key: "mobile",
          width: 180,
        },
        {
          title: "身份证",
          key: "IDcard",
          width: 200,
        },
        {
          title: "银行卡号",
          key: "bank_num",
          width: 200,
        },
        {
          title: "开户行(支行)",
          key: "opening_bank"
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
      this.form = { sex:1 };
    },
    saved() {
      this.showEditor = false;
      this.showAddBank = false;
      this.getData();
    },
    getData() {
      axios
        .request({
          method: "get",
          url: "api/cost/members",
          params: {
            page:this.page
          }
        })
        .then(res => {
          this.data = res.data.data;
          this.pagination = res.data.pagination;
        });
    },
    getHospital() {
      axios
        .request({
          method: "get",
          url: "api/cost/hospitals",
        })
        .then(res => {
          this.companys = res.data.data;
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
              url: "api/cost/members/" + row.id
            })
            .then(res => {
              this.getData();
            });
        },
        onCancel: () => {}
      });
    },
    handleEdit(data) {
      this.getData();
      this.form = data;
      this.showEditor = true;
    },
    addbank(data) {
      this.form = data;
      this.showAddBank = true;
    },
    changePage(page) {
      this.page = page;
      this.getData();
    },
    searchData() {
      let method = "GET";
      let url = "api/cost/msearch/";
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
    searchDatas(id) {
      let method = "GET";
      let url = "api/cost/msearch/";
          url += this.hospital?this.hospital:0;
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
  },
  mounted() {
    this.getData();
    this.getHospital();
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
.search_button{
  position: absolute;
  left: 240px;
}
.search_select{
  position: absolute;
  left: 410px;
  height: 31.5px;
  width: 200px;
}
</style>
