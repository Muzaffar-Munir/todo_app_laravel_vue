 
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
              <section class="manage-subscription">
                <div class="container">
                  <div v-if="loader">
                    <div class="spinner"></div>
                  </div>
                  <div v-if="jobs && jobs.data">
                    <div
                      class="row manage-subscription-row mb-4"
                      v-for="job in jobs.data"
                      :key="job.id"
                    >
                      <div class="col-md-9 main-text manage-ads-main-text">
                        <div class="text">
                          <strong>Client:</strong>
                          <span
                            v-if="job.service && job.service.client && job.service.client.user"
                          >{{ job.service.client.user.first_name }} {{ job.service.client.user.last_name }}</span>
                        </div>
                        <div class="text">
                          <strong>Job Title</strong>
                          <span v-if="job.service">{{ job.service.title ? job.service.title:'' }}</span>
                        </div>

                        <div class="text">
                          <img
                            :src="job.service && job.service.attachment ? '/images/services/'+job.service.attachment: '/images/avatar.png'"
                          />
                        </div>
                      </div>
                      <div class="col-md-3 link-img">
                        <router-link
                          :to="{name: 'indexViewService', params: {id:job.service.id } }"
                        >
                          <img
                            src="../../../../public/assets/images/Untitled-1_03.jpg"
                            class="mr-4"
                          />
                        </router-link>
                        <a href="#" data-toggle="modal" data-target="#deleteJobModal">
                          <img src="../../../../public/assets/images/Untitled-1_05.jpg" />
                        </a>
                      </div>

                      <div
                        class="modal fade model-style"
                        id="deleteJobModal"
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
                                <p>Do you really want to delete this item?</p>
                                <div class="view-btn view-delete">
                                  <button
                                    class="edit"
                                    @click.stop.prevent="deleteApplication(job.id)"
                                  >YES</button>
                                  <button class="delete" data-dismiss="modal">NO</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="container-fluid" v-if="jobs">
                      <div class="row">
                        <div class="col-sm-3 offset-sm-2"></div>
                        <div class="col-sm-4">
                          <pagination :data="jobs" :limit="2" @pagination-change-page="getResults"></pagination>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div v-else>
                    <div class="row manage-ads-row mb-4">
                      <div class="col-md-9 main-text manage-ads-main-text">
                        <div class="text">You don't have Applied any Job</div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
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
  components: {
    dashboardNavComponent,
  },
  mounted() {
    // Fetch initial results
    this.getResults();
  },
  data() {
    return {
      jobs: null,
      loader: true,
      freelancer: null,
    };
  },
  methods: {
    async getResults(page = 1) {
      this.loader = true;
      // this.subscriptions = (
      //   await axios.get("/api/user_subscribe_client?page=" + page)
      // ).data;
      this.jobs = (
      await axios.get(
        "/index.php/api/apply_job?page=" + page+"&freelancer=" + this.freelancer.id
      )
    ).data;
      this.loader = false;
    },
    deleteApplication(id) {
      this.loader = true;
      axios
        .delete("/index.php/api/apply_job/" + id)
        .then((response) => {
          if (response.status && response.status == 200) {
            this.jobs = axios
              .get("/index.php/api/apply_job?freelancer=" + this.freelancer.id)
              .then((job_response) => {
                if (job_response.status && job_response.status == 200) {
                  this.jobs = job_response.data;
                  this.services = response.data;
                  $("body").removeClass("modal-open");
                  $(".fade").removeClass("modal-backdrop");
                  $("body").css("padding-right", "0px");
                  this.loader = false;
                }
              })
              .catch(() => {
                this.loader = false;
              });
          }
        })
        .catch(() => {
          this.loader = false;
        });
    },
  },
  async created() {
    this.freelancer = JSON.parse(
      localStorage.getItem("current_user")
    ).freelancer;
    
    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
};
</script>