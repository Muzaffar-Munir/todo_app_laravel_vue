<template>
  <div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="viewAppliedJobsApplicants"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalScrollableTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">Job Applicants</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="false">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container" style="text-align: justify;text-justify: inter-word;">
              <div id="accordion" class="accordion">
                <div
                  class="card mb-0"
                  v-for="(data, index) in applicants"
                  :key="data.id"
                  style="cursor:pointer"
                >
                  <!-- start loop -->
                  <div
                    class="card-header collapsed"
                    data-toggle="collapse"
                    :href="'#collapse-'+index"
                  >
                    <a class="card-title">
                      <span class="cyan-words">
                        <span
                          v-if="data.freelancer && data.freelancer.user"
                        >{{ data.freelancer.user.first_name ?data.freelancer.user.first_name : '' }} {{ data.freelancer.user.last_name ?data.freelancer.user.last_name : '' }}</span>
                      </span>
                    </a>
                  </div>

                  <div :id="'collapse-'+index" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                      <div>
                        <div v-if="data.freelancer.description">{{ data.freelancer.description }}</div>
                        <br />
                        <b>For any questions or notices, please him at:</b>
                        <br />

                        <div class="row">
                          <div
                            class="col-md-6"
                            v-if="data.freelancer && data.freelancer.user && data.freelancer.user.email"
                          >
                            Email:
                            <a
                              :href="'mailto:'+data.freelancer.user.email"
                              style="display:inline"
                            >{{ data.freelancer.user.email }}</a>
                          </div>
                          <div class="col-md-6 text-right">
                            <!-- <router-link :to="{name:'userProfile', params:{id:data.freelancer.id}}"> -->
                              <button type="button" class="btn btn-more" @click.stop="viewMore(data.freelancer.id)">View more</button>
                            <!-- </router-link> -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end loop -->
                </div>
                <div
                  v-if="!applicants || !applicants.length"
                >Currently there is no Applicants in this Job</div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      applicants: null,
    };
  },
  props: ["id"],
  methods: {
    viewMore(id){
        $("body").removeClass("modal-open");
      $(".fade").removeClass("modal-backdrop");
      $("body").css("padding-right", "0px");
      $('#viewAppliedJobsApplicants').modal('hide');
      this.$router.push({name: 'userProfile', params:{id:id}})
    }
  },
  async created() {
    if (this.id) {
      this.applicants = (
        await axios.get(
          "/index.php/api/apply_job/" + this.id + "?applicants=true"
        )
      ).data;
    }
  },
};
</script>
<style scoped>
.btn-more {
  background-color: #5cc9be;
  color: white;
}
</style>