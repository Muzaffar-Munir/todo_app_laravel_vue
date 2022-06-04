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

              <div class="container">
                <div class="row">
                  <div class="col-md-12">
                    <div class="new-btn">
                      <h5>Manage your Advertisement</h5>
                      <router-link :to="{name:'create-service'}">
                        <button class="back">BACK</button>
                      </router-link>
                    </div>
                  </div>
                </div>

                <div v-if="loader">
                  <div class="spinner"></div>
                </div>
                <div v-if="services && services.data">
                  <div
                    class="row manage-ads-row mb-4"
                    v-for="service in services.data"
                    :key="service.id"
                  >
                    <div class="col-md-9 main-text manage-ads-main-text">
                      <div class="text">
                        <strong>Title:</strong>
                        <p
                          v-if="service.title && service.title.length>20"
                        >{{ service.title.slice(0, 20) }}....</p>
                        <p v-if="service.title && service.title.length<20">{{ service.title }}</p>
                      </div>
                      <div class="text">
                        <strong>Des:</strong>
                        <p
                          v-if="service.description && service.description.length>20"
                        >{{ service.description.slice(0, 20) }}....</p>
                        <p
                          v-if="service.description && service.description.length<20"
                        >{{ service.description }}</p>
                      </div>
                      <div class="text">
                        <strong>Price:</strong>
                        ${{ service.price ? service.price: '' }}
                      </div>
                      <div class="text">
                        <img class="preview-image-width"
                          :src="service.attachment ? '/images/services/'+service.attachment: '/images/avatar.png'"
                        />
                      </div>
                    </div>
                    <div class="col-md-3 link-img">
                      <router-link :to="{name: 'viewService', params: {id:service.id } }">
                        <img src="../../../../public/assets/images/Untitled-1_03.jpg" />
                      </router-link>
                      <router-link :to="{name: 'updateClientService', params: {id:service.id } }">
                        <img src="../../../../public/assets/images/Untitled-1_04.jpg" />
                      </router-link>
                      <a href="#" data-toggle="modal" data-target="#exampleModal">
                        <img src="../../../../public/assets/images/Untitled-1_05.jpg" />
                      </a>
                    </div>

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
                              <p>Do you really want to delete this item?</p>
                              <div class="view-btn view-delete">
                                <button
                                  class="edit"
                                  @click.stop.prevent="deleteService(service.id)"
                                >YES</button>
                                <button class="delete" data-dismiss="modal">NO</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="container-fluid" v-if="services">
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
                <div v-else>
                  <div class="row manage-ads-row mb-4">
                    <div class="col-md-9 main-text manage-ads-main-text">
                      <div class="text">You don't have created any service</div>
                    </div>
                  </div>
                </div>
              </div>
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
      services: null,
      user: null,
      loader: true,
    };
  },
  methods: {
    async getResults(page = 1) {
      this.loader = true;
      this.services = (
        await axios.get(
          "/index.php/api/service?page=" + page + "&user_id=" + this.user.id
        )
      ).data;
      this.loader = false;
    },
    deleteService(id) {
      this.loader = true;
      axios
        .delete("/index.php/api/service/" + id)
        .then((response) => {
          if (response.status && response.status == 200) {
            axios
              .get("/index.php/api/service?user_id=" + this.user.id)
              .then((response) => {
                if (response.status && response.status == 200) {
                  this.services = response.data;
                  $("body").removeClass("modal-open");
                  $(".fade").removeClass("modal-backdrop");
                  $("body").css("padding-right", "0px");
                  this.loader = false;
                }
              })
              .catch((error) => {
                this.loader = false;
              })
              .then(() => {
                this.loader = false;
              });
          }
        })
        .catch((error) => {
          this.loader = false;
        })
        .then(() => {
          this.loader = false;
        });
    },
  },
  async created() {
    if (localStorage.getItem("current_user")) {
      this.user = JSON.parse(localStorage.getItem("current_user")).user;
      this.loader = false;
      // setTimeout(() => {
      //   this.loader = false;
      // }, 1000);
    }
  },
};
</script>