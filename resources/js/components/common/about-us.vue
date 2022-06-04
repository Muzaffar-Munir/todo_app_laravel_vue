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
            <h3>About Us!</h3>
          </div>
        </div>
      </div>
    </section>

    <section class="approach-us">
      <div class="container">
        <div class="row mb-4 main-content">
          <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-lg-10 col-xl-10">
              <div class="approach-form text-left custom-padding">
                <!-- start first section -->
                <h4
                  class="font-weight-bold mt-4"
                >Do you want to know the secret to increasing your business sales without investing more of your valuable time and hard-earned money?</h4>
                <hr />
                <div>
                  <div class="p-content">
                    Imagine having hundreds of sales professionals successfully selling your product or service anywhere in the world without paying them a salary or wage.
                    Take a moment to in vision how much more profitable your business would be if you only paid your employee once they had closed a sale rather than a salary or hourly rate to find a sale.
                    You might be thinking; Yes I can understand how that would help my business be more profitable but how can someone like me find strong skilled sales professionals to sell my product without me paying them a salary? Good Question
                  </div>
                </div>
                <!-- ending first section -->
                <!-- start second section -->
                <h4
                  class="font-weight-bold mt-4"
                >Here you will find the ambitious people with drive that should be working for you</h4>
                <hr />
                <div>
                  <div class="p-content">
                    Going independent is a conscious choice for those who are confident in their own skills and ability to deliver strong and consistent results. Those who choose to work as a Freelancer not only choose it for the flexibility for work life balance as well as the financial upside but also for personal growth.
                    Freelance work is expected to rise by 40% by the end of 2020 and 68% say their quality of life has increased since making the transition from the traditional 9-5.
                    <br />
                    <br />
                    <u class="mt-4">Who has a side hustle?</u>
                    <ul>
                      <li>51% of the U.S work force</li>
                      <li>35% of the Canadian work force</li>
                      <li>40% of the U.K work force</li>
                      <li>¼ Australians</li>
                    </ul>Since the world pandemic forced us all into lockdown the worlds unemployment rate is predicted to reach over 20% and with government stimulus packages coming to an end more people will be looking to hustle for businesses like yours.
                    Businesses across the world are looking to cut costs forcing them to scale down instead of up. Sales professional turnover rates are near 35% and can be expensive, requiring not only the costs of wasted training and investment, but also of acquiring a replacement. Its because of this that 40% of CEOs are now planning to stay ahead of the curve by seeking alternative outsourcing roles and responsibilities to freelancers to keep the business cost effective.
                    <b>Will you?</b>
                  </div>
                </div>
                <!-- ending second section -->
                <!-- start third section -->
                <h4 class="font-weight-bold mt-4">
                  Turn $299 into
                  <u>Thousands</u> of dollars
                </h4>
                <hr />
                <div>
                  <div class="p-content">
                    If you want to free yourself to allow more time to enjoy the pleasures of life or even just more time to apply to other areas of your business then this is for you.
                    The time has come for you to upscale your business without hiring someone on a salary.
                    We offer the MOST convenient and affective option available to help you upscale your business for the highest return on investment available on the market.
                    What we do is connect you to Sales professionals all over the world who want to sell your product for a
                    <u>commission only</u>, that’s right No salary, no hourly rate, just a commission that both parties agree on. It is the quickest and most cost-effective way to upscale your business during these times.
                  </div>
                  <br />
                  <br />
                  <div class="p-content mt-4">
                    By signing up with us for only $299 per 30 days it wont take more than 1 sale before you have an impressive increase on return for investment.
                    It is much cheaper than recruiting someone, training them only for them to quit on you shortly after you have invested valuable time and money.
                    <br />
                    <br />
                    <ul>
                      <li>Dave has a product that sells for $2000</li>
                      <li>Dave spends $299 a month to post his product with us</li>
                      <li>Dave has advertised 10% commission to anyone who can sell his product</li>
                      <li>One Rep made $200 by selling Dave’s product to a customer</li>
                      <li>Dave has already made over 300% return on investment after commission</li>
                      <li>If Dave can have a Rep sell one a week that’s $93,600 after commission</li>
                      <li>Now imagine you are Dave and you have multiple Sales reps replicating this process</li>
                      <li>Now you are upscaling your business</li>
                    </ul>Now imagine that gains momentum over time, what would that look like for you and your business.
                    <b>Exciting right?</b>
                    <div>Here are what other businesses are achieving with us: TESTIMONIALS LINK</div>
                    <br />
                    <div>Currently there are many platforms that offer Freelance services, most commonly for Graphic Design, Web development, Data entry, accounting, bookkeeping just to name a few but there is no platform purely dedicated to seek the best freelance sales professionals in the world.</div>
                    <br />
                    <div>All the alternative platforms generally require you to charge an hourly rate or a fee per project and once the project has been completed you are required to pay the platform a commission of at least 3%. Alternatively you can pay hundreds of dollars to post an add to recruit someone or potentially thousands to have an agency do it for you when all this money could have been spent on commission only making you thousands of dollars on your return for investment along the way.</div>
                    <br />
                    <div>So now you have 2 options: you can continue what you’re doing, settle with what you are earning now with no time or money to spare but let’s be frank you would not have read up to this point if you wanted that. You are here because you believe that you deserve a better career and lifestyle than the one you have now. SECOND OPTION: You can have freedom to spend more time on things that you prefer to do whether it be focusing your attention on other areas of the business or creating special memories and bonds with family and loved ones. Allow us to reach more people than you ever could on your own, don’t spend money on hiring people who will ultimately over promise and under deliver, allow us to provide a community who will demonstrate that they can sell your product before you pay them not the other way around.</div>
                  </div>
                  <h4
                    class="font-weight-bold mt-4"
                  >To help businesses during these unprecedented times we are giving away the first 30 days FREE, limited time only.</h4>
                  <br />
                  <br />Now that you have established how to solve the problem, what do I do to get started?
                  <router-link :to="{path:'/client/Signup'}" style="color:#5cc9be;">Get started now</router-link>
                </div>
                <!-- ending third section -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
export default {
  data() {
    return {
      loader: true,
    };
  },
  created() {
    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
};
</script>
<style scoped>
.custom-padding{
  padding: 40px 30px;
}
</style>