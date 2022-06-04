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
              <!-- Starting Content -->
              <div class="container">
                <div class="row">
                  <div class="col-md-12">
                    <div class="new-btn">
                      <h5>Manage Advertisement</h5>
                    </div>
                  </div>
                </div>

                <div v-if="services && services.data && services.data.length">
                  <vue-good-table :columns="columns" :rows="services.data">
                    <template slot="table-row" slot-scope="props">
                      <span v-if="props.column.field == 'actions'">
                       
                        <span
                          class="fa fa-trash-o ml-4"
                          style="cursor:pointer"
                          @click="showDeleteModal(props.row)"
                        ></span>
                        <span
                          class="fa fa-eye-slash ml-4"
                          style="cursor:pointer"
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
                  <div class="container-fluid pt-4" v-if="services">
                    <div class="row">
                      <div class="col-sm-3 offset-sm-2"></div>
                      <div class="col-sm-4">
                        <pagination
                          :data="services"
                          :limit="2"
                          @pagination-change-page="getResults"
                        ></pagination>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-else>No services created yet</div>
              </div>
              <!-- ending Content -->
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import dashboardNavComponent from "./dashboardNav";

export default {
  mounted() {
    // Fetch initial results
    this.getResults();
  },
  data() {
    return {
      services: null,
      loader: true,
      modalText: null,
      modelData: null,
      type: null,
      page: null,
      columns: [
        {
          label: "Title",
          field: "title",
        },
        {
          label: "Price",
          field: "price",
        },
        {
          label: "Business Name",
          field: "client.business_name",
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
  components: {
    dashboardNavComponent,
  },
  methods: {
    async getResults(page = 1) {
      this.page = page;
      this.loader = true;
      // this.subscriptions = (
      //   await axios.get("/api/user_subscribe_client?page=" + page)
      // ).data;
      // this.loadServices(this.page);
      this.services = (
        await axios.get("/index.php/api/service?page=" + page)
      ).data;
      this.services.data = this.services.data.map((data) => {
        if (data.client && data.client.user) {
          data.client_name = data.client.user.full_name;
        }
        return data;
      });
      this.rows = this.services;
      this.loader = false;
    },
    showActiveInactiveModal(data) {
      $("#exampleModal").modal("show");
      this.modelData = data;
      this.changeModelText();
      this.type = "inactive";
      // axios.put("/index.php/api/user/" + id +'?status_change', { status: "inactive" });
    },
    changeModelText() {
      if (this.modelData.status == "active") {
        this.modalText = "Do you really want to inactive this user?";
      } else if (this.modelData.status == "inactive") {
        this.modalText = "Do you really want to active this user?";
      }
    },
    // Call to action for delete and active/inactive
    async UserAction() {
      this.loader = true;
      if (this.type == "delete") {
        axios
          .delete("/index.php/api/service/" + this.modelData.id)
          .then((response) => {
            if (response.status && response.status == 200) {
              $("body").removeClass("modal-open");
              $(".fade").removeClass("modal-backdrop");
              $("body").css("padding-right", "0px");
              $("#exampleModal").modal("hide");
              this.loadServices();
            }
          })
          .catch((error) => {
            $("body").removeClass("modal-open");
            $(".fade").removeClass("modal-backdrop");
            $("body").css("padding-right", "0px");
            $("#exampleModal").modal("hide");
            this.loader = false;
          })
          .then(() => {
            $("body").removeClass("modal-open");
            $(".fade").removeClass("modal-backdrop");
            $("body").css("padding-right", "0px");
            $("#exampleModal").modal("hide");
            this.loader = false;
          });
      } else {
        if (this.modelData.status == "inactive") {
          this.modelData.status = "active";
        } else if (this.modelData.status == "active") {
          this.modelData.status = "inactive";
        }
        this.changeModelText();
        axios
          .post("/index.php/api/services/status?id=" + this.modelData.id, {
            status: this.modelData.status,
          })
          .then((response) => {
            if (response.status && response.status == 200) {
              // this.tableData =
              this.loadServices();
              $("body").removeClass("modal-open");
              $(".fade").removeClass("modal-backdrop");
              $("body").css("padding-right", "0px");
              $("#exampleModal").modal("hide");
              this.loader = false;
            }
          })
          .catch((errors) => {
            $("body").removeClass("modal-open");
            $(".fade").removeClass("modal-backdrop");
            $("body").css("padding-right", "0px");
            $("#exampleModal").modal("hide");
            this.loader = false;
          });
      }
    },

   
    async loadServices() {
      this.loader = true;
      this.services = (await axios.get("/index.php/api/service")).data;
      this.services.data = this.services.data.map((data) => {
        if (data.client && data.client.user) {
          data.client_name = data.client.user.full_name;
        }
        return data;
      });
      this.rows = this.services;
      this.loader = false;
    },
    showDeleteModal(data) {
      $("#exampleModal").modal("show");
      this.modelData = data;
      this.modalText = "Do you really want to delete this Ad?";
      this.type = "delete";
    },
  },
  async created() {
    setTimeout(() => {
      this.loader = false;
    }, 1000);
    // }
  },
};
</script>