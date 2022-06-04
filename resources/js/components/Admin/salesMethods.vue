<template>
  <div>
    <div v-if="loader">
      <div class="spinner"></div>
    </div>
    <!-- section-top-->
    <section class="create-account-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
             <h3>Dashboard</h3>
          </div>
        </div>
      </div>
    </section>

    <section class="create-account">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 tab-responsive">
            <dashboard-nav-component></dashboard-nav-component>
          </div>

          <div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9">
            <div id="update" class="tabcontent" style="display:block">
              <div class="create-account-content"></div>

              <!-- start content-->
              <div class="container">
                <div class="row">
                  <div class="col-md-12">
                    <div class="new-btn mb-4">
                      <h5>Manage Sales Methods</h5>
                      <router-link :to="{name:'sales-methods-add'}">
                        <button class="back">ADD NEW</button>
                      </router-link>
                    </div>
                  </div>
                </div>

                <div v-if="tableData && tableData.data && tableData.data.length">
                  <vue-good-table :columns="columns" :rows="tableData.data">
                    <template slot="table-row" slot-scope="props">
                      <span v-if="props.column.field == 'actions'">
                        <router-link
                          :to="{name:'sales-methods-update', params:{ id: props.row.id, title: props.row.title}}"
                        >
                          <span class="fa fa-edit ml-4" style="cursor:pointer"></span>
                        </router-link>
                        <span
                          class="fa fa-trash-o ml-4"
                          style="cursor:pointer"
                          @click="showDeleteModal(props.row)"
                        ></span>
                       

                        <div
                          class="modal fade model-style"
                          id="exampleModal"
                          tabindex="-1"
                          role="dialog"
                          aria-labelledby="exampleModalLabel"
                          aria-hidden="true"
                        >
                          <div class="pop-up-setting" style="display: flex; align-items: center;">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button
                                    type="button"
                                    class="close"
                                    data-dismiss="modal"
                                    aria-label="Close"
                                  >
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>{{ modalText }}</p>
                                  <div class="view-btn view-delete">
                                    <button
                                      class="edit"
                                      @click.stop.prevent="UserAction(props.row)"
                                    >YES</button>

                                    <button class="delete" data-dismiss="modal">NO</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </span>
                      <span v-else>{{props.formattedRow[props.column.field]}}</span>
                    </template>
                  </vue-good-table>
                
                  <div class="container-fluid pt-4" v-if="tableData">
                    <div class="row">
                      <div class="col-sm-3 offset-sm-2"></div>
                      <div class="col-sm-4">
                        <pagination
                          :data="tableData"
                          :limit="2"
                          @pagination-change-page="getResults"
                        ></pagination>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-else>No Sales methods created yet</div>
              </div>
              <!-- end -->
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import moment from "moment";
import dashboardNavComponent from "./dashboardNav";
export default {
  components: {
    dashboardNavComponent,
  },
   mounted() {
    // Fetch initial results
    this.getResults();
  },
  data() {
    return {
      loader: true,
      tableData: null,
      modalText: "",
      type: "",
      modelData: null,
      id: null,
        columns: [
        {
          label: "Title",
          field: "title",
        },
       
        {
          label: "Created Date",
          field: "created_at",
        },
        {
          label: "Actions",
          field: "actions",
        },
      ],
    };
  },
  methods: {
     async getResults(page = 1) {
      this.loader = true;
       this.tableData = (await axios.get("/index.php/api/sales_methods?page="+page)).data;
      this.tableData.data = this.tableData.data.map((data) => {
        if (data.created_at) {
          data.created_at = moment(String(data.created_at)).format(
            "MM/DD/YYYY"
          );
        }
        return data;
      });
      this.loader = false;
    },
    editEvent(row) {
      this.id = row.id;
    },

    showDeleteModal(data) {
      $("#exampleModal").modal("show");
      this.modelData = data;
      this.modalText = "Do you really want to delete this Sales Method?";
      this.type = "delete";
    },

    async UserAction() {
      this.loader = true;

      axios
        .delete("/index.php/api/sales_methods/" + this.modelData.id)
        .then((response) => {
          if (response.status && response.status == 200) {
            this.getSalesMethods();
            this.loader = false;
            $("body").removeClass("modal-open");
            $(".fade").removeClass("modal-backdrop");
            $("body").css("padding-right", "0px");
            $("#exampleModal").modal("hide");
          }
        })
        .catch((errors) => {
          this.loader = false;
          $("body").removeClass("modal-open");
          $(".fade").removeClass("modal-backdrop");
          $("body").css("padding-right", "0px");
          $("#exampleModal").modal("hide");
        });
    },
   
    async getSalesMethods(page=1) {
      this.tableData = (await axios.get("/index.php/api/sales_methods?page="+page)).data;
      this.tableData.data = this.tableData.data.map((data) => {
        if (data.created_at) {
          data.created_at = moment(String(data.created_at)).format(
            "MM/DD/YYYY"
          );
        }
        return data;
      });
    },
  },
  created() {
    // this.getSalesMethods();
    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
};
</script>
<style>
.vxe-cell {
  font-size: 23px !important;
}
</style>