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
                    <div class="new-btn">
                      <h5>Manage Users</h5>
                    </div>
                  </div>
                </div>

                <div v-if="rows && rows.data && rows.data.length">
                   <vue-good-table :columns="columns" :rows="rows.data">
                    <template slot="table-row" slot-scope="props">
                      <span v-if="props.column.field == 'actions'">
                        <span
                          class="fa fa-edit"
                          style="cursor:pointer"
                          @click="editEvent(props.row)"
                          data-toggle="modal"
                          data-target="#resetPasswordModal"
                        ></span>
                        <span class="fa fa-trash-o ml-4"  style="cursor:pointer" @click="showDeleteModal(props.row)"></span>
                        <span
                          class="fa fa-eye-slash ml-4"  style="cursor:pointer"
                          @click="showActiveInactiveModal(props.row)"
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
                                    <button class="edit" @click.stop.prevent="UserAction(props.row)">YES</button>

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
                        <pagination :data="tableData" :limit="2" @pagination-change-page="getResults"></pagination>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-else>No User created yet</div>
              </div>
              <!-- end -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- reset password component start -->
    <reset-password-modal v-if="id" :id="id"></reset-password-modal>
    <!-- ending -->
  </div>
</template>
<script>
import dashboardNavComponent from "./dashboardNav";
import resetPasswordModal from "./resetPasswordModal";
export default {
  components: {
    dashboardNavComponent,
    resetPasswordModal,
  },
  mounted() {
    // Fetch initial results
    this.getResults();
  },
  data() {
    return {
      loader: true,
      users: null,
      tableData: null,
      modalText: "",
      type: "",
      modelData: null,
      id: null,
      columns: [
        {
          label: "Name",
          field: "full_name",
        },
         {
          label: "Email",
          field: "email",
        },
        {
          label: "Role",
          field: "role",
        },
        {
          label: "Status",
          field: "status",
        },
        {
          label: "Actions",
          field: "actions",
        },
      ],
      rows: null,
    };
  },
  methods: {
    async getResults(page = 1) {
      this.loader = true;
      this.tableData = (await axios.get("/index.php/api/user?page="+page+"&role=admin")).data;
       this.rows = (await axios.get("/index.php/api/user?page="+page+"&role=admin")).data;
       console.log(this.rows);
      this.loader = false;
    },
    editEvent(row) {
      this.id = row.id;
      console.log(row);
      console.log(this.id);
    },
    showActiveInactiveModal(data) {
      $("#exampleModal").modal("show");
      this.modelData = data;
      this.changeModelText();
      this.type = "inactive";
      // axios.put("/index.php/api/user/" + id +'?status_change', { status: "inactive" });
    },
    showDeleteModal(data) {
      $("#exampleModal").modal("show");
      this.modelData = data;
      this.modalText = "Do you really want to delete this user?";
      this.type = "delete";
    },
    changeModelText() {
      if (this.modelData.status == "active") {
        this.modalText = "Do you really want to inactive this user?";
      } else if (this.modelData.status == "inactive") {
        this.modalText = "Do you really want to active this user?";
      }
    },
    async UserAction() {
      this.loader = true;
      if (this.type == "inactive" && this.modelData) {
        if (this.modelData.status == "inactive") {
          this.modelData.status = "active";
        } else if (this.modelData.status == "active") {
          this.modelData.status = "inactive";
        }
        this.changeModelText();
        axios
          .put(
            "/index.php/api/user/" +
              this.modelData.id +
              "?status_change=" +
              this.modelData.status,
            {
              status: this.modelData.status,
            }
          )
          .then((response) => {
            if (response.status && response.status == 200) {
              // this.tableData =
              axios
                .get("/index.php/api/user?role=admin")
                .then((users) => {
                  if (response) {
                    this.tableData = users.data;
                     this.rows = users.data;
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
            }
          })
          .catch((errors) => {
            this.loader = false;
            $("body").removeClass("modal-open");
            $(".fade").removeClass("modal-backdrop");
            $("body").css("padding-right", "0px");
            $("#exampleModal").modal("hide");
          });
      } else {
        axios
          .delete("/index.php/api/user/" + this.modelData.id)
          .then((response) => {
            if (response.status && response.status == 200) {
              axios
                .get("/index.php/api/user?role=admin")
                .then((getUsers) => {
                  if (getUsers) {
                    this.tableData = getUsers.data;
                    this.rows = getUsers.data;
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
              // this.tableData = (await axios.get("/index.php/api/user?role=admin")).data;
            }
          })
          .catch((errors) => {
            this.loader = false;
            $("body").removeClass("modal-open");
            $(".fade").removeClass("modal-backdrop");
            $("body").css("padding-right", "0px");
            $("#exampleModal").modal("hide");
          });
      }
    },
  },
  async created() {
    // this.tableData = (await axios.get("/index.php/api/user?role=admin")).data;
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