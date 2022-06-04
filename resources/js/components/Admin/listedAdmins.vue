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
                      <h5>Manage Admins</h5>
                    </div>
                  </div>
                </div>

                <div v-if="tableData && tableData.length">
                  <vue-good-table :columns="columns" :rows="rows">
                    <template slot="table-row" slot-scope="props">
                      <span v-if="props.column.field == 'actions'">
                        <span
                          class="fa fa-edit"
                          style="cursor:pointer"
                          @click="editEvent(props.row)"
                          data-toggle="modal"
                          data-target="#resetPasswordModal"
                        ></span>
                        <span
                          class="fa fa-trash-o ml-4"
                          style="cursor:pointer"
                          v-if="current_admin && props.row.id != current_admin.id"
                          :disabled="props.row.id == current_admin.id"
                          @click="props.row.id != current_admin.id ? showDeleteModal(props.row) : ''"
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
  data() {
    return {
      loader: true,
      current_admin: null,
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
      rows: null,
    };
  },
  methods: {
    editEvent(row) {
      this.id = row.id;
    },

    showDeleteModal(data) {
      $("#exampleModal").modal("show");
      this.modelData = data;
      this.modalText = "Do you really want to delete this user?";
      this.type = "delete";
    },

    async UserAction() {
      this.loader = true;
      //   if (this.modelData.id == this.current_admin.id) {
      //       ("#exampleModal").modal("show");
      //       this.modalText = "You can't delet";
      //   } else {
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
      //   }
    },

  },
  async created() {
    this.tableData = (await axios.get("/index.php/api/users/admins")).data;
    this.rows = (await axios.get("/index.php/api/users/admins")).data;
    if (localStorage.getItem("admin_user")) {
      this.current_admin = JSON.parse(localStorage.getItem("admin_user"));
    }

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