<template>
  <div>
    <div v-if="loader">
      <div class="spinner"></div>
    </div>
    <!-- section-top-->
    <section class="approach-us-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <!-- <h3>Contact us!</h3> -->
          </div>
        </div>
      </div>
    </section>

    <section class="approach-us">
      <div class="container">
        <div class="row mb-4 main-content">
          <h3>Contact us</h3>
          <!-- <p>Please write down your inquery or questions and we will get back to you soon.</p> -->
        </div>
        <div class="row d-flex justify-content-center">
          <div class="col-md-10 col-lg-9 col-xl-8">
            <div class="approach-form">
              <form @submit.stop.prevent="Submit()">
                <div class="form-spacing">
                  <div class="form-group mb-2 custom-form">
                    <input
                      type="text"
                      name="subject"
                      class="form-control"
                      placeholder="Subject *"
                      required
                      autofocus
                      v-model="formObj.subject"
                      :class="[{'is-invalid': errorFor('subject')}]"
                    />
                    <v-errors :errors="errorFor('subject')"></v-errors>
                  </div>
                  <div class="form-group mb-2 custom-form mt-3">
                    <textarea
                      class="form-control foam-border comment-box"
                      placeholder="Message"
                      rows="4"
                      required
                      cols="50"
                      name="comment"
                      form="usrform"
                      v-model="formObj.message"
                    ></textarea>
                  </div>
                  <div class="form-group mb-2 custom-form">
                    <input
                      type="email"
                      name="email"
                      class="form-control"
                      placeholder="Email *"
                      v-model="formObj.email"
                      required
                      :class="[{'is-invalid': errorFor('email')}]"
                    />
                    <v-errors :errors="errorFor('email')"></v-errors>
                  </div>
                  <div class="form-group mb-2 custom-form">
                    <input
                      type="text"
                      name="contact"
                      class="form-control"
                      placeholder="Contact *"
                      required
                      v-model="formObj.contact"
                      :class="[{'is-invalid': errorFor('contact')}]"
                    />
                    <v-errors :errors="errorFor('contact')"></v-errors>
                  </div>
                </div>
                <div class="form-group approach-content">
                  <p>Our customer service representative will be in contact with you shortly!</p>
                  <button class="btn-approach mt-4 ml-5" type="submit">SEND</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div
      class="modal fade model-style"
      id="successModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="pop-up-setting" style="display: flex; align-items: center;">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              Success
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>We will contact you shortly!</p>
              <div class="view-btn view-delete">
                <button class="delete" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import validationErrors from "../../mixins/validationErrors";
import { is422 } from "../../utils/response";
export default {
  mixins: [validationErrors],
  data() {
    return {
      loader: true,
      status: null,
      errors: null,
      formObj: {
        subject: null,
        message: null,
        email: null,
        contact: null,
      },
    };
  },
  computed: {
    hasErrors() {
      return 422 === this.status && this.errors !== null;
    },
  },
  created() {
    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
  methods: {
    async Submit() {
      this.loader = true;
      const data = axios
        .post("/index.php/api/contact_us", this.formObj)
        .then((data) => {
          console.log(data);
          if (data.status && data.status == 200) {
            $("#successModal").modal("show");
            this.loader = false;
            this.formObj = {
              subject: null,
              message: null,
              email: null,
              contact: null,
            };
            $("body").removeClass("modal-open");
            $(".fade").removeClass("modal-backdrop");
            $("body").css("padding-right", "0px");
            this.loader = false;
          }
        })
        .catch((error) => {
          console.log(error);
          if (is422(error)) {
            this.errors = error.response.data.errors;
          }
          this.status =
            error.response && error.response.status
              ? error.response.status
              : "";
          $("body").removeClass("modal-open");
          $(".fade").removeClass("modal-backdrop");
          $("body").css("padding-right", "0px");
          this.loader = false;
        })
        .then(() => {
          $("body").removeClass("modal-open");
          $(".fade").removeClass("modal-backdrop");
          $("body").css("padding-right", "0px");
          this.loader = false;
        });
    },
  },
};
</script>