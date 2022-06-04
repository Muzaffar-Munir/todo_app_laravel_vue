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
                      <h5>Cancelled Subscriptions</h5>
                    </div>
                  </div>
                </div>

                <div v-if="Queries && Queries.data && Queries.data!=''">
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
                <div v-else>No Client has cancelled his subscription yet</div>
              </div>
              <!-- ending Content -->
            </div>
          </div>
        </div>
        <view-query-modal v-if="viewContent" :data="viewContent"></view-query-modal>
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
          label: "Name",
          field: "user.full_name",
        },

        {
          label: "Buniess Name",
          field: "user.client.business_name",
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
        await axios.get("/index.php/api/cancel_subscription?page=" + page)
      ).data;
      if (this.Queries.data) {
        this.Queries.data = this.Queries.data.map((data) => {
          if (data.reason && data.reason.length > 10) {
            data.shown_message = data.reason.slice(0, 10) + "...";
          } else {
            data.shown_message = data.reason;
          }
          return data;
        });
      }
      this.loader = false;
    },

    deleteQuery() {
      this.loader = true;
      axios
        .delete("/index.php/api/cancel_subscription/" + this.delete_id)
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
      this.Queries = (await axios.get("/index.php/api/cancel_subscription")).data;
      if (this.Queries.data) {
        this.Queries = this.Queries.map((data) => {
          if (data.reason && data.reason.length > 10) {
            data.shown_message = data.reason.slice(0, 10) + "...";
          } else {
            data.shown_message = data.reason;
          }
          return data;
        });
      }
      this.loader = false;
    },
  },
};
</script>