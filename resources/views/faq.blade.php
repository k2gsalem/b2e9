<x-app-layout>
    <div x-data="alpFaq" class="pg-container py-8 flex flex-col md:flex-row gap-8">
        <div class="flex-1 space-y-4">
            <div class="text-xl font-bold">FAQ's</div>
            <x-faq-item>
                <x-slot name="title">
                    What is B2E Hub and how it works?
                </x-slot>
                B2E Hub is a unique online bidding website which acts a bridge between the suppliers who submits bids and the customers / clients who posts Projects related to manufacturing sector.
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    Who can participate in B2E Hub online?
                </x-slot>
                B2E Hub encourages all entrepreneurs who hold a valid GST to get involved in bidding.
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    Who are Clients & Suppliers?
                </x-slot>
                Clients/Customers are those who Posts their requirements as Projects and the Suppliers are those who competes in the bidding to avail the Projects.
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    How can I start bidding on B2E Hub?
                </x-slot>
                First, signup in to our website B2EHub.com as supplier. We Provide exciting membership Packages, grab any plan which is affordable and start bidding.
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    What are bidding Packages available in B2E Hub?
                </x-slot>
                Clients/Customers are those who Posts their requirements as Projects and the Suppliers are those who competes in the bidding to avail the Projects.
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    Where do B2E Hub get the live rates of Commodities from?
                </x-slot>
                B2E Hub get the commodities price from the Leading Global Players in the market and by considering share values.
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    Is it legal to enroll in such online Bidding service and to participate in them?
                </x-slot>
                Yes, Absolutely. Online Biddings are legal in India and we have to meet with all compliance requirements of RBI, various Banks and Payment Gateway service providers.
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    How long does a B2E Hub Bidding last?
                </x-slot>
                <h3>Let us clarify:</h3>
                <p><b>There are 3 different types of time constraints prevailing in B2E Hub Platform</b></p>
                <ul>
                    <li><b>Study Time</b> – Time Mentioned by the Customer to study the Posted Drawing.</li>
                    <li><b>Bidding Time</b> – It is the Last 30 mins of the study Time where the Real Bidding Starts. Registered Suppliers Participate in the Auction by Biding in this Time to gain project.</li>
                    <li><b>Project Time</b> – Time Denoted by the Customer to complete a Project.</li>
                </ul>
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    Does each Project have the same Bid Time?
                </x-slot>
                <p>Yes, All Bid starts 30 minutes before the Study Time; all registered suppliers within the specified limits (Limits has been set by the Customers while Posting the Projects) will be notified prior. </p>
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    What are editable bids?
                </x-slot>
                <p>Editable Bids are the bids that supplier can change during the bidding time. For ex, if an amount been posted by the supplier and if he/she is willing to change the same in between, B2E Hub provides a leverage Option called Edit Bids in which they can change the same.</p>
            </x-faq-item>
        </div>
        <div class="flex-1 space-y-4">
            <div class="text-xl font-bold">
                What type of products / Services does B2E Hub Post in Website for Bidding?
            </div>
            <x-faq-item>
                <x-slot name="title">
                    Can I open more than one account on B2E Hub?
                </x-slot>
                <p>Yes, But each user should have a different mail id and Phone number with a Valid GSTIN. Note: Multiple Accounts can be operated with a Single GST Number.</p>
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    Is there any winning limit? Can I participate in all the Bids?
                </x-slot>
                <p>There are no limits at B2E Hub. Users can participate in unlimited Bidding based on their membership package. </p>
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    I was shortlisted for a bid, what to do now?
                </x-slot>
                <p>Good. If you have received a message as Shortlisted, kindly hold on till the customer reverts.</p>
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    What is prohibited while bidding at B2EHub.com?
                </x-slot>
                <h3>Let us clarify:</h3>
                <p><b>Below activities are strictly prohibited and it will be treated as violation of our terms and conditions</b></p>
                <ul>
                    <li>Participate in an auction in a group of few users together from a same household or a same place</li>
                    <li>Using any third party bidding software/tools/scripts to place automatic bids, or to operate your account using such methods</li>
                    <li>Accessing an user account from different workstations or devices and placing BIDS using different devices at a same time during an auction</li>
                </ul>
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    What are the payment methods to avail the Membership plans or to make payments for the projects?
                </x-slot>
                <p>We use RBI approved payment gateways like – Easy buzz, It supports Debit Cards, Credit Cards, Wallets, Paytm, UPI, Net Banking,. You may also make payment in to our bank account. Contact our billing team on billing {at} B2EHub {dot} com for any assistance with the payments.</p>
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    My question is not listed here and I need further clarifications
                </x-slot>
                <p>Please Post your Queries to the mail id: info@B2EHub.com or call xxxxxxxxxx.</p>
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    Can I get my Bid Back?
                </x-slot>
                <p>Bids are most Valuable aspect to gain a Project; if you are a Supplier with Prime membership you can replenish your winning bid.</p>
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    I have terms Issue with the Customer/ suppliers, whom to contact?
                </x-slot>
                <p>You are free to contact our Customer care for any such Issues and it would be sorted out as per the Company Policy.</p>
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    Am I eligible for the rewards & Offers?
                </x-slot>
                <p>Yes, if you are an Existing user you are eligible for the rewards and Offers.</p>
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    Am I Eligible for the referral Bonus?
                </x-slot>
                <p>Yes, if you are an Existing user you are eligible for the Referral Bonus , you can Refer a customer or a supplier with a  referral code assigned to you.</p>
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    How and when can I upgrade my Plan?
                </x-slot>
                <p>You can upgrade via our website or call our executives to get upgraded, you can upgrade to a new Plan from an Existing at any point of time.</p>
            </x-faq-item>
            <x-faq-item>
                <x-slot name="title">
                    Why I didn’t win any Projects even using all my bids?
                </x-slot>
                <p>You were just short of winning, work close on the Project costing more Precise, Note that you are in a Competitive bidding Platform. Customers Validates Several Criteria’s before a Project. Current auction winners are once beginners, so keep bidding. </p>
            </x-faq-item>
        </div>
    </div>

    @push('scripts')
        <script>
            function alpFaq() {
                return {
                    activeId: null,
                    toggle: function (id) {
                        this.activeId = this.isActive(id) ? null : id;
                    },
                    isActive: function (id) {
                        return id === this.activeId;
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
