    
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
            <!-- <h3>Cancel Account</h3> -->
          </div>
        </div>
      </div>
    </section>
    <section class="manage-ads" v-if="type">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="new-btn">
              <h5>View Advertisement Details</h5>
              <router-link :to="{ name:'clientListServices' }" v-if="!type">
                <button class="back">BACK</button>
              </router-link>
              <router-link :to="{ name:'services' }" v-if="type">
                <button class="back">BACK</button>
              </router-link>
            </div>
          </div>
        </div>
        <div v-if="loader">
          <div class="spinner"></div>
        </div>

        <div class="row view-ads" v-if="service">
          <div class="col-md-6">
            <img
              :src="service.attachment ? '/images/services/'+service.attachment: '/images/avatar.png'"
              alt="img"
            />
            <h2>DESCRIPTION OF PRODUCT OR CONCEPT</h2>
            <p>{{service.description ? service.description :''}}</p>
          </div>

          <div class="col-md-6 right-secion">
            <h2>TITLE OF PRODUCT/CONCEPT</h2>
            <p>{{ service.title ? service.title :'' }}</p>
            <h2>PRICE OF PRODUCT/CONCEPT</h2>
            <p>${{service.price ? service.price :''}}.</p>

            <h2>PREFERRED SALES METHODS</h2>
            <p v-if="subscription_type!=0 && subscription_type!=5">{{service.sales_methods && service.sales_methods.title ? service.sales_methods.title :''}}</p>
            <p v-if="subscription_type==0 || subscription_type==5">
              <update-plan-text></update-plan-text>
            </p>

            <h2>TARGET AUDIENCE</h2>
            <p v-if="subscription_type!=0 && subscription_type!=5">{{service.audience ? service.audience :''}}</p>
            <p v-if="subscription_type==0 || subscription_type==5">
              <update-plan-text></update-plan-text>
            </p>

            <h2>TARGET LOCATION</h2>
            <p v-if="subscription_type!=0 && subscription_type!=5">{{service.location ? service.location :''}}</p>
            <p v-if="subscription_type==0 || subscription_type==5">
              <update-plan-text></update-plan-text>
            </p>

            <h2>REQUIREMENTS FOR THE ROLE</h2>
            <p v-if="subscription_type!=0 && subscription_type!=5">{{service.requirements ? service.requirements :''}}</p>
            <p v-if="subscription_type==0 || subscription_type==5">
              <update-plan-text></update-plan-text>
            </p>

            <h2>BUSINESS URL</h2>
            <p class="description">{{service.url ? service.url :''}}</p>

            <div class="view-btn" v-if="!type">
              <router-link :to="{name: 'updateClientService', params: {id:service.id } }">
                <button class="edit">EDIT</button>
              </router-link>
              <button class="delete ml-3" data-toggle="modal" data-target="#exampleModal">DELETE</button>
              <button
                class="edit ml-3"
                data-toggle="modal"
                data-target="#viewAppliedJobsApplicants"
              >
                <!-- <i class="fa fa-eye" aria-hidden="true"></i>  -->
                Applicants
              </button>
            </div>
            <div class="view-btn" v-if="current_user && current_user.freelancer">
              <button
                class="edit"
                @click.stop.prevent="ApplyJob()"
                v-if="!applied_jobs || !applied_jobs.includes(freelancer_id)"
              >Apply for Job</button>
              <button
                class="delete"
                v-if="applied_jobs && applied_jobs.includes(freelancer_id)"
              >Job Applied</button>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="create-account" v-if="!type">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 tab-responsive">
            <dashboard-nav-component></dashboard-nav-component>
          </div>

          <div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9">
            <div id="update" class="tabcontent" style="display:block">
              <div class="create-account-content"></div>
              <!-- <reset-password-component></reset-password-component> -->

              <!-- starting dashboard -->
              <section class="manage-ad">
                <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="new-btn">
                        <h5>View Advertisement Details</h5>
                        <router-link :to="{ name:'clientListServices' }" v-if="!type">
                          <button class="back">BACK</button>
                        </router-link>
                        <router-link :to="{ name:'services' }" v-if="type">
                          <button class="back">BACK</button>
                        </router-link>
                      </div>
                    </div>
                  </div>
                  <div v-if="loader">
                    <div class="spinner"></div>
                  </div>

                  <div class="row view-ads" v-if="service">
                    <div class="col-md-6">
                      <img
                        :src="service.attachment ? '/images/services/'+service.attachment: '/images/avatar.png'"
                        alt="img"
                      />
                      <h2>DESCRIPTION OF PRODUCT OR CONCEPT</h2>
                      <p>{{service.description ? service.description :''}}</p>
                    </div>

                    <div class="col-md-6 right-secion">
                      <h2>TITLE OF PRODUCT/CONCEPT</h2>
                      <p>{{ service.title ? service.title :'' }}</p>
                      <h2>PRICE OF PRODUCT/CONCEPT</h2>
                      <p>${{service.price ? service.price :''}}.</p>
                      <h2>PREFERRED SALES METHODS</h2>
                      <p>{{service.sales_methods && service.sales_methods.title ? service.sales_methods.title :''}}.</p>

                      <h2>TARGET AUDIENCE</h2>
                      <p>{{service.audience ? service.audience :''}}.</p>

                      <h2>TARGET LOCATION</h2>
                      <p>{{service.location ? service.location :''}}</p>

                      <h2>REQUIREMENTS FOR THE ROLE</h2>
                      <p>{{service.requirements ? service.requirements :''}}</p>

                      <h2>BUSINESS URL</h2>
                      <p class="description">{{service.url ? service.url :''}}</p>

                      <div class="view-btn" v-if="!type">
                        <router-link :to="{name: 'updateClientService', params: {id:service.id } }">
                          <button class="edit">EDIT</button>
                        </router-link>
                        <button
                          class="delete ml-3"
                          data-toggle="modal"
                          data-target="#exampleModal"
                        >DELETE</button>
                        <button
                          class="edit ml-3"
                          data-toggle="modal"
                          data-target="#viewAppliedJobsApplicants"
                        >Applicants</button>
                      </div>
                      <div class="view-btn" v-if="current_user && current_user.freelancer">
                        <button
                          class="edit"
                          @click.stop.prevent="ApplyJob()"
                          v-if="!applied_jobs || !applied_jobs.includes(freelancer_id)"
                        >Apply for Job</button>
                        <button
                          class="delete"
                          v-if="applied_jobs && applied_jobs.includes(freelancer_id)"
                        >Job Applied</button>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Do you really want to delete this item?</p>
                        <div class="view-btn view-delete">
                          <button class="edit" @click.stop.prevent="deleteService(service.id)">YES</button>
                          <button class="delete" data-dismiss="modal">NO</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <my-job-applicants v-if="service" :id="service.id"></my-job-applicants>

              <!-- ending dashboard -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <div
      class="modal fade model-style"
      id="jobModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="jobModalLabel"
      aria-hidden="true"
    >
      <div class="pop-up-setting" style="display: flex; align-items: center;">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5>Job Applied</h5>
            </div>
            <div class="modal-body">
              <p>You have Successfully Applied for this Job</p>
            </div>
            <div class="modal-footer">
              <div class="view-btn view-delete">
                <button class="delete pull-right" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import myJobApplicants from "./../Clients/myJobApplicants";
import dashboardNavComponent from "./../Clients/dashboardNav";
import { getClientsubscriptionType } from "../../utils/auth";
import updatePlanText from "../Clients/upgradePlantext";
export default {
  components: {
    myJobApplicants,
    dashboardNavComponent,
    updatePlanText
  },
  props: ["type"],
  data() {
    return {
      service: null,
      loader: true,
      id: null,
      current_user: null,
      freelancer_id: null,
      applied_jobs: null,
       subscription_type: getClientsubscriptionType(),
    };
  },
  methods: {
    // apply job as a freelancer
    async ApplyJob() {
      const postData = {
        freelancer_id: this.current_user.freelancer.id,
        service_id: this.service.id,
      };
      axios.post("/index.php/api/apply_job", postData).then((response) => {
        if (response.status && response.status == 200) {
          $("#jobModal").modal("show");
          axios
            .get(
              "/index.php/api/apply_job/" +
                this.service.id +
                "?applid_user=" +
                this.current_user.freelancer.id
            )
            .then((applied) => {
              this.applied_jobs = applied.data;
              this.applied_jobs = this.applied_jobs.map((obj) => {
                return obj.freelancer_id;
              });
            });
        }
      });
    },

    // delete service action for client
    deleteService(id) {
      this.loader = true;
      axios
        .delete("/index.php/api/service/" + id)
        .then((response) => {
          if (response.status && response.status == 200) {
            axios;
            this.$router.push({ name: "clientDashboard" });
            $("body").removeClass("modal-open");
            $(".fade").removeClass("modal-backdrop");
            $("body").css("padding-right", "0px");
            this.$router.push({ name: "clientListServices" });
            this.loader = false;
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
    this.id = this.$route.params.id;
    this.service = (await axios.get("/index.php/api/service/" + this.id)).data;
    if (localStorage.getItem("current_user")) {
      this.current_user = JSON.parse(localStorage.getItem("current_user"));
      if (this.current_user.freelancer) {
        this.freelancer_id = this.current_user.freelancer.id;
      }
    }
    if (this.type && this.current_user && this.current_user.freelancer) {
      this.applied_jobs = (
        await axios.get(
          "/index.php/api/apply_job/" +
            this.service.id +
            "?applid_user=" +
            this.current_user.freelancer.id
        )
      ).data;
      this.applied_jobs = this.applied_jobs.map((obj) => {
        return obj.freelancer_id;
      });
    }
    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
};
</script>