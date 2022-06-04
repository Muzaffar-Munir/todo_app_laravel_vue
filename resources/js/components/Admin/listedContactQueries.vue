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
                      <h5>Manage Queries</h5>
                    </div>
                  </div>
                </div>

                <div v-if="Queries && Queries.data && Queries.data.length">
                  <vue-good-table :columns="columns" :rows="Queries.data">
                    <template slot="table-row" slot-scope="props">
                      <span v-if="props.column.field == 'actions'">
                        <span
                          class="fa fa-eye ml-4"
                          style="cursor:pointer"
                          data-toggle="modal"
                          data-target="#viewQueryModal"
                          @click="viewQueryDetail(props.row)"
                        ></span>
                        <span
                          class="fa fa-trash ml-4"
                          style="cursor:pointer"
                          icon="fa fa-trash"
                          data-toggle="modal"
                          data-target="#deleteQueryModal"
                          @click="delete_id = props.row.id"
                        ></span>
                      </span>
                      <span v-else>{{props.formattedRow[props.column.field]}}</span>
                    </template>
                  </vue-good-table>
                  <div class="container-fluid pt-4" v-if="Queries">
                    <div class="row">
                      <div class="col-sm-3 offset-sm-2"></div>
                      <div class="col-sm-4">
                        <pagination :data="Queries" :limit="2" @pagination-change-page="getResults"></pagination>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-else>No Query created yet</div>
              </div>
              <!-- ending Content -->
            </div>
          </div>
        </div>
        <view-query-modal v-if="viewContent" :data="viewContent"></view-query-modal>
        <!-- showing delete modal -->
        <div
          class="modal fade model-style"
          id="deleteQueryModal"
          tabindex="-1"
          role="dialog"
          aria-labelledby="deleteQueryModal"
          aria-hidden="true"
        >
          <div class="pop-up-setting" style="display: flex; align-items: center;">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Do you really want to delete this query?</p>
                  <div class="view-btn view-delete">
                    <button class="edit" @click.stop.prevent="deleteQuery()">YES</button>

                    <button class="delete" data-dismiss="modal">NO</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- ending delete modal -->
      </div>
    </section>
  </div>
</template>
<script>
import dashboardNavComponent from "./dashboardNav";
import viewQueryModal from "./viewQueryModal";
export default {
  components: {
    dashboardNavComponent,
    viewQueryModal,
  },
  mounted() {
    // Fetch initial results
    this.getResults();
  },
  data() {
    return {
      loader: true,
      Queries: null,
      viewContent: null,
      delete_id: null,
      columns: [
        {
          label: "Subject",
          field: "subject",
        },

        {
          label: "Email",
          field: "email",
        },
        {
          label: "Message",
          field: "shown_message",
        },
        {
          label: "Actions",
          field: "actions",
        },
      ],
    };
  },
  async created() {
    // this.getQueries();

    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
  methods: {
    async getResults(page = 1) {
      this.loader = true;
      this.Queries = (
        await axios.get("/index.php/api/contact_us?page=" + page)
      ).data;
      if (this.Queries.data) {
        this.Queries.data = this.Queries.data.map((data) => {
          if (data.message.length > 10) {
            data.shown_message = data.message.slice(0, 10) + "...";
          } else {
            data.shown_message = data.message;
          }
          return data;
        });
      }
      this.loader = false;
    },

    deleteQuery() {
      this.loader = true;
      axios
        .delete("/index.php/api/contact_us/" + this.delete_id)
        .then((response) => {
          if (response.status && response.status == 200) {
            this.getQueries();

            $("body").removeClass("modal-open");
            $(".fade").removeClass("modal-backdrop");
            $("body").css("padding-right", "0px");
            $("#deleteQueryModal").modal("hide");
          }
        })
        .catch((error) => {
          this.loader = false;
        })
        .then(() => {
          this.loader = false;
        });
    },
    viewQueryDetail(data) {
      this.viewContent = data;
    },
    // getting Queries
    async getQueries() {
      this.loader = true;
      this.Queries = (await axios.get("/index.php/api/contact_us")).data;
      if (this.Queries.data) {
        this.Queries = this.Queries.map((data) => {
          if (data.message.length > 10) {
            data.shown_message = data.message.slice(0, 10) + "...";
          } else {
            data.shown_message = data.message;
          }
          return data;
        });
      }
      this.loader = false;
    },
  },
};
</script>