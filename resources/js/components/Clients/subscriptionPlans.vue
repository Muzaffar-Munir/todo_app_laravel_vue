<template>
  <div>
    <div v-if="loader">
      <div class="spinner"></div>
    </div>
    <!-- staart plans -->
    <section class="services">
      <div class="container">
        <div class="row main-heading">
          <div class="col-md-12 text-center">
            <h1>Choose one of the following</h1>
          </div>
        </div>

        <div class="row service-box">
          <div class="col-12 col-md-12 col-lg-4 service-col">
            <div class="service-options">
              <div class="service-rate service-rate-1">
                <h3>COVID RELIEF OFFER</h3>
                <h1 class="top-rate">FREE</h1>
                <p>
                  <i>
                    Try for free till
                    <br />The end of 2020
                  </i>
                </p>
              </div>
              <div
                class="service-discription"
              >ENDS IN {{ years }} {{ months }} {{ days }} {{ hours }}H {{ minitues }}M</div>
              <div class="service-list">
                <ul>
                  <li>Display the following:</li>
                  <li>Product or service</li>
                  <li>Price and Commission</li>
                </ul>
              </div>
              <button
                class="subscribed-btn"
                v-if="client.subscription_type && client.subscription_type==0"
              >Current Plan</button>
              <button
                class="subscribed-btn"
                v-if="client.subscription_type && (client.subscription_type==5 || client.subscription_type==10)"
              >Expired</button>
              <button
                class="btn-block"
                v-if="client.subscription_type && client.subscription_type!=0 && client.subscription_type!=5 && client.subscription_type!=10"
                :disabled="client.subscription_type && (client.subscription_type==1 || client.subscription_type==2 )"
                @click.stop.prevent="Subscribe(0)"
              >JOIN</button>
            </div>
          </div>

          <div class="col-12 col-md-12 col-lg-4 service-col">
            <div class="service-options">
              <div class="service-rate service-rate-2">
                <h3>30 DAYS SUBSCRIPTION</h3>
                <h1 class="top-rate">
                  <span v-if="!is_referal">$299</span>
                  <span v-if="is_referal">
                    $269
                    <p>
                      <s>299</s> (Referal Discount)
                    </p>
                  </span>
                </h1>
              </div>
              <div class="service-list">
                <ul>
                  <li>Display the following:</li>
                  <li>Product or service</li>
                  <li>Price and Commission</li>
                  <li>Prerequisites</li>
                  <li>Target Audience</li>
                  <li>Target Location</li>
                  <li>Preferred sales methods</li>
                </ul>
              </div>
              <button
                class="subscribed-btn"
                v-if="client.subscription_type && client.subscription_type==1"
              >Current Plan</button>
              <button
                class="btn-block"
                data-toggle="modal"
                data-target="#paymentModal"
                :disabled="client.subscription_type && (client.subscription_type==1 || client.subscription_type==2)"
                @click="selectedPlan=monthly_subscription; subscription_title='Monthly Plan'"
                v-if="client.subscription_type && client.subscription_type!=1"
              >JOIN</button>
            </div>
          </div>
          <div class="col-12 col-md-12 col-lg-4 service-col">
            <div class="service-options">
              <div class="service-rate service-rate-2">
                <h3>12 MONTHS SUBSCRIPTION</h3>
                <h1 class="top-rate">
                  <span v-if="!is_referal">$ 2,499</span>
                  <span v-if="is_referal">
                    $2,249
                    <p>
                      <s>2,499</s> (Referal Discount)
                    </p>
                  </span>
                </h1>
              </div>
              <div class="service-list">
                <ul>
                  <li>Display the following:</li>
                  <li>Product or service</li>
                  <li>Price and Commission</li>
                  <li>Prerequisites</li>
                  <li>Target Audience</li>
                  <li>Target Location</li>
                  <li>Preferred sales methods</li>
                  <li>Access to view Sales professional profiles</li>
                  <li>Top priority for your industry</li>
                  <li>Automated email sent to Sales professionals looking to work for your rate or industry</li>
                </ul>
              </div>

              <button
                class="subscribed-btn"
                v-if="client.subscription_type && client.subscription_type==2"
              >Current Plan</button>
              <button
                class="btn-block"
                data-toggle="modal"
                data-target="#paymentModal"
                @click="selectedPlan=annual_subscription; subscription_title='Annual Plan'"
                v-if="client.subscription_type && client.subscription_type!=2"
              >JOIN</button>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- view pricing modal -->

    <div
      class="modal fade model-style"
      id="paymentModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="pop-up-setting" style="display: flex; align-items: center;">
        <div class="modal-dialog width" role="document">
          <div class="modal-content">
            <div class="modal-header">
              Payment details
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
              <form class="row" @submit.stop.prevent="submitPaymentMethod()">
                <div class="col-12 mb-2">
                  <label class="pull-left">Card Holder Name *</label>
                  <input
                    id="card-holder-name"
                    type="text"
                    placeholder="Card Holder Name *"
                    v-model="name"
                    required
                    class="form-control mb-2"
                  />
                </div>
                <br />
                <div class="col-12 mb-2">
                  <label class="pull-left">Card</label>
                  <div id="card-element"></div>
                </div>

                <button
                  class="btn btn-info mt-3 pull-right centered-align"
                  id="add-card-button"
                  type="submit"
                >Save Payment Method</button>
                <div
                  v-show="paymentMethodsLoadStatus == 2 
    && paymentMethods.length == 0"
                  class="col-12"
                >No payment method added yet, please add a payment method.</div>

                <div
                  v-show="paymentMethodsLoadStatus == 2 
        && paymentMethods.length > 0"
                  class="col-12"
                >
                  <div class="mt-3 mb-3">OR</div>
                  <div
                    v-for="(method, key) in paymentMethods"
                    v-bind:key="'method-'+key"
                    v-on:click="paymentMethodSelected = method.id;selectedPlanTitle = method.selectedPlanTitle"
                    class="border rounded row p-1"
                    v-bind:class="{
            'bg-success text-light': paymentMethodSelected == method.id    
        }"
                  >
                    <div
                      class="col-2"
                    >{{ method.brand.charAt(0).toUpperCase() }}{{ method.brand.slice(1) }}</div>
                    <div
                      class="col-7"
                    >Ending In: {{ method.last_four }} Exp: {{ method.exp_month }} / {{ method.exp_year }}</div>
                    <div class="col-3">
                      <span v-on:click.stop="removePaymentMethod( method.id )">Remove</span>
                    </div>
                  </div>
                </div>
              </form>
              <button
                class="btn btn-info mt-3 pull-right pay-btn"
                id="add-card-button"
                v-if="paymentMethodSelected && paymentMethodSelected.length"
                @click.prevent="updateSubscription()"
                :disabled="loader"
              >Pay Now</button>

              <!-- <div class="view-btn view-delete pull-right">
                <button class="delete" data-dismiss="modal">Close</button>
              </div>-->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ending pricing modal -->

    <!-- Success modal -->

    <div
      class="modal fade model-style"
      id="paymentSuccessModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="paymentSuccessModalLabel"
      aria-hidden="true"
    >
      <div class="pop-up-setting" style="display: flex; align-items: center;">
        <div class="modal-dialog width" role="document">
          <div class="modal-content">
            <div class="modal-header">
              Payment {{ payment_status }}!
            </div>
            <div class="modal-body">
              <p
                class="text-left" v-if="payment_status=='success'"
              >Thanks for making the payment. You are successfully subscribed to {{ subscription_title && subscription_title=='Annual' ? '12 MONTHS SUBSCRIPTION': subscription_title && subscription_title=='Monthly'? '30 DAYS SUBSCRIPTION':'' }} package.</p>
              <p class="text-left" v-if="payment_status=='failed'">
              Your Referal coupon is already used. Please contact support
              </p>
              <div class="view-btn view-delete pull-right">
                <button class="edit" @click.stop.prevent="redirectToDashboard()">Dashboard</button>
                <button class="delete" data-dismiss="modal" v-if="payment_status=='failed'">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ending success modal -->
  </div>
</template>
<script>
export default {
  data() {
    return {
      loader: true,
      diffDays: null,
      dayString: null,
      years: null,
      months: null,
      days: null,
      hours: null,
      minitues: null,
      isSuccess: false,
      client: null,
      user: null,

      // stripe config
      stripeAPIToken: null,
      stripe: "",
      elements: "",
      card: "",
      intentToken: "",
      name: "",
      addPaymentStatus: 0,
      addPaymentStatusError: "",
      paymentMethods: [],
      paymentMethodsLoadStatus: 0,
      paymentMethodSelected: {},
      selectedPlan: "",
      subscription_title: null,
      selectedPlanTitle: null,
      is_referal: null,
      monthly_subscription: null,
      annual_subscription: null,
      referal_coupon: null,
      payment_status:null,
    };
  },
  watch: {
    selectedPlan() {
      this.paymentMethodSelected = {};
    },
  },
  methods: {
    redirectToDashboard() {
      $("body").removeClass("modal-open");
      $(".fade").removeClass("modal-backdrop");
      $("body").css("padding-right", "0px");
      $("#paymentSuccessModal").modal("hide");
      this.$router.push({
        name: "client-subscription",
      });
    },
    Subscribe(type) {
      this.loader = true;
      const requset = { selected_plan: type };
      const response = axios
        .put(
          "/index.php/api/client/" + this.client.id + "?type=subscribe",
          requset
        )
        .then((response) => {
          if (response.status && response.status == 200) {
            this.isSuccess = true;
            this.loader = false;
            // updating local storage
            axios
              .get(
                "/index.php/api/user/" + this.user.id + "?profile-details=true"
              )
              .then((user) => {
                localStorage.setItem("current_user", JSON.stringify(user.data));
              })
              .catch((error) => {
                this.loader = false;
              })
              .then(() => {
                this.loader = false;
              });
            setTimeout(() => {
              this.$router.push({ name: "listFreelancers" });
            }, 2000);
          }
        });
    },
    // stripe config
    /*
        Includes Stripe.js dynamically
    */
    includeStripe(URL, callback) {
      let documentTag = document,
        tag = "script",
        object = documentTag.createElement(tag),
        scriptTag = documentTag.getElementsByTagName(tag)[0];
      object.src = "//" + URL;
      if (callback) {
        object.addEventListener(
          "load",
          function (e) {
            callback(null, e);
          },
          false
        );
      }
      scriptTag.parentNode.insertBefore(object, scriptTag);
    },
    configureStripe() {
      this.stripe = Stripe(
        this.stripeAPIToken
      );

      this.elements = this.stripe.elements();
      this.card = this.elements.create("card");

      this.card.mount("#card-element");
    },
    async loadIntent() {
      axios
        .get("/index.php/api/users/setup-intent?user_id=" + this.user.id)
        .then(
          function (response) {
            this.intentToken = response.data;
          }.bind(this)
        );
    },
    submitPaymentMethod() {
      this.addPaymentStatus = 1;

      this.stripe
        .confirmCardSetup(this.intentToken.client_secret, {
          payment_method: {
            card: this.card,
            billing_details: {
              name: this.name,
            },
          },
        })
        .then(
          function (result) {
            if (result.error) {
              this.addPaymentStatus = 3;
              this.addPaymentStatusError = result.error.message;
            } else {
              this.savePaymentMethod(result.setupIntent.payment_method);
              this.addPaymentStatus = 2;
              this.card.clear();
              this.name = "";
            }
          }.bind(this)
        );
    },
    /*
    Saves the payment method for the user and
    re-loads the payment methods.
*/
    savePaymentMethod(method) {
      axios
        .post("/index.php/api/users/payments", {
          payment_method: method,
          user: this.user.id,
        })
        .then(
          function () {
            this.loadPaymentMethods();
          }.bind(this)
        );
    },
    removePaymentMethod(paymentID) {
      axios
        .post("/index.php/api/users/remove-payment", {
          id: paymentID,
          user: this.user.id,
        })
        .then(
          function (response) {
            this.loadPaymentMethods();
          }.bind(this)
        );
    },
    /*
    Loads all of the payment methods for the
    user.
*/
    loadPaymentMethods() {
      this.paymentMethodsLoadStatus = 1;

      axios
        .get("/index.php/api/users/payment-methods?user_id=" + this.user.id)
        .then(
          function (response) {
            this.paymentMethods = response.data;

            this.paymentMethodsLoadStatus = 2;
          }.bind(this)
        );
    },
    async getUser() {
      const userObj = (
        await axios.get(
          "/index.php/api/user/" +
            this.user.id +
            "?profile-details=true&type=client"
        )
      ).data;
      localStorage.setItem("current_user", JSON.stringify(userObj));
    },
    updateSubscription() {
      this.loader = true;
      const data = {};
      data.plan = this.selectedPlan;
      data.payment = this.paymentMethodSelected;
      data.user = this.user.id;
      data.subscription_title = this.subscription_title;
     
      if (this.is_referal) {
       
        if(this.referal_coupon){
          data.coupon = this.referal_coupon;
        } else{
           data.coupon ='referal';
        }
      }
      axios
        .put("/index.php/api/users/subscription", data)
        .then(
          function (response) {
            this.loader = false;
            $("#paymentModal").modal("hide");
            this.getUser();
            this.payment_status='success';
            $("#paymentSuccessModal").modal("show");
            
          }.bind(this)
        )
        .catch((errors) => {
          $("body").removeClass("modal-open");
          $(".fade").removeClass("modal-backdrop");
          $("body").css("padding-right", "0px");
          $("#paymentModal").modal("hide");
           $("#paymentSuccessModal").modal("show");
          if(errors.response && errors.response.status==406){
              this.payment_status='failed';
          }
          
          this.loader = false;
        });
    },

    // Days to months, years logic
    getDifference() {
      // finding diffrence between current date and end of current date for time
      var today = new Date();
      var month = today.getMonth() + 1;
      // var endToday = new Date("2020-10-19 23:59:59");
      var endToday = new Date(
        today.getFullYear() + "-" + month + "-" + today.getDate() + " 23:59:59"
      );
      var diffMs = endToday - today; // milliseconds between now & end of day
      this.hours = Math.floor((diffMs % 86400000) / 3600000); // hours
      this.minitues = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes

      const date_1 = new Date();
      const date_2 = new Date("12/31/" + new Date().getFullYear());
      //convert to UTC
      var date2_UTC = new Date(
        Date.UTC(
          date_2.getUTCFullYear(),
          date_2.getUTCMonth(),
          date_2.getUTCDate()
        )
      );
      var date1_UTC = new Date(
        Date.UTC(
          date_1.getUTCFullYear(),
          date_1.getUTCMonth(),
          date_1.getUTCDate()
        )
      );

      var yAppendix, mAppendix, dAppendix;

      //--------------------------------------------------------------
      var days = date2_UTC.getDate() - date1_UTC.getDate();
      if (days < 0) {
        date2_UTC.setMonth(date2_UTC.getMonth() - 1);
        days += DaysInMonth(date2_UTC);
      }
      //--------------------------------------------------------------
      var months = date2_UTC.getMonth() - date1_UTC.getMonth();
      if (months < 0) {
        date2_UTC.setFullYear(date2_UTC.getFullYear() - 1);
        months += 12;
      }
      //--------------------------------------------------------------
      var years = date2_UTC.getFullYear() - date1_UTC.getFullYear();

      if (years > 1) yAppendix = " years";
      else yAppendix = " year";
      if (months > 1) mAppendix = " months";
      else mAppendix = " month";
      if (days > 1) dAppendix = " days";
      else dAppendix = " day";

      let string = "";
      if (years != 0) {
        this.years = years + "Y";
        string = years + yAppendix + ", ";
      }
      if (months != 0) {
        this.months = months + "M";
        string += months + mAppendix + ", and ";
      }
      if (days != 0) {
        this.days = days + "D";
        string += days + dAppendix + ", ";
      }
      this.dayString = string;
      return this.dayString;
    },

    DaysInMonth(date2_UTC) {
      var monthStart = new Date(
        date2_UTC.getFullYear(),
        date2_UTC.getMonth(),
        1
      );
      var monthEnd = new Date(
        date2_UTC.getFullYear(),
        date2_UTC.getMonth() + 1,
        1
      );
      var monthLength = (monthEnd - monthStart) / (1000 * 60 * 60 * 24);
      return monthLength;
    },
  },
  mounted() {
    this.includeStripe(
      "js.stripe.com/v3/",
      function () {
        this.configureStripe();
      }.bind(this)
    );
    this.loadIntent();
    this.loadPaymentMethods();
  },
  async created() {
    this.monthly_subscription = process.env.MIX_STRIPE_MONTHLY_SUBSCRIPTION;
    this.annual_subscription = process.env.MIX_STRIPE_ANNUAL_SUBSCRIPTION;
    this.stripeAPIToken =  process.env.MIX_STRIPE_KEY;
    
    if (localStorage.getItem("current_user")) {
      this.client = JSON.parse(localStorage.getItem("current_user")).client;
      this.user = JSON.parse(localStorage.getItem("current_user")).user;
      if (
        this.client.referal_email &&
        this.client.referal_email != null &&
        this.client.referal_email != "null" &&
        this.client.referal_email != undefined
      ) {
        this.is_referal = (await axios.post("/index.php/api/clients/client-referal", {
          email: this.client.referal_email,
        })).data;
        
         this.referal_coupon = process.env.MIX_REFERAL_DISCOUNT;
      }
      setTimeout(() => {
        this.loader = false;
      }, 1000);
    }
    this.getDifference();
  },
};
</script>
<style scoped>
.bg-success {
  background-color: #151313 !important;
  opacity: 0.8;
}
.pay-btn {
  background-color: #5cc9be !important;
}
.pay-btn:hover {
  border: none;
  border-color: unset;
}
.centered-align {
  margin: 40px auto 10px auto;
}
.width {
  width: 34%;
}
</style>