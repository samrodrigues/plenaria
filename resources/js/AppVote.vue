<template>
    <div class="">
        <fieldset
            v-for="(poll, index) in polls"
            :key="poll.key"
            :class="{ 'mt-10': index }"
        >
            <legend class="text-md mt-5 font-medium text-gray-700">
                {{ poll.title }}
            </legend>
            <p class="text-sm text-gray-500">
                Selecione os candidatos em quem deseja votar.<br />Você pode
                escolher até {{ getMaxAllowedCandidates(poll) }}.
            </p>
            <div
                class="
                    mt-4
                    border-t border-b border-gray-200
                    divide-y divide-gray-200
                "
            >
                <div
                    v-for="(candidate, candidateIdx) in poll.candidates"
                    :key="candidateIdx"
                    class="relative flex items-start py-4"
                >
                    <div class="min-w-0 flex-1 text">
                        <label
                            :for="`candidate-${candidate.id}`"
                            class="font-medium text-gray-700 select-none"
                            :class="{
                                'text-gray-200': vote.includes(poll.title),
                            }"
                            >{{ candidate.name }}</label
                        >
                    </div>
                    <div class="ml-3 flex items-center h-5">
                        <input
                            :disabled="vote.includes(poll.title)"
                            :id="`candidate-${candidate.id}`"
                            :name="`candidate-${candidate.id}`"
                            v-model="vote"
                            :value="candidate.id"
                            type="checkbox"
                            :class="{ hidden: vote.includes(poll.title) }"
                            class="
                                focus:ring-emerald-500
                                h-8
                                w-8
                                text-emerald-600
                                border-gray-300
                                rounded
                            "
                        />
                    </div>
                </div>
                <div class="relative flex items-start py-4">
                    <div class="min-w-0 flex-1 text">
                        <label
                            :for="`candidate-0`"
                            class="font-medium text-gray-700 select-none"
                            >Voto em branco</label
                        >
                    </div>
                    <div class="ml-3 flex items-center h-5">
                        <input
                            :id="`candidate-0`"
                            :name="`candidate-0`"
                            v-model="vote"
                            :value="poll.title"
                            type="checkbox"
                            class="
                                focus:ring-emerald-500
                                h-8
                                w-8
                                text-emerald-600
                                border-gray-300
                                rounded
                            "
                        />
                    </div>
                </div>
            </div>
        </fieldset>

        <div class="mt-10">
            <button
                @click="sendVote"
                class="
                    w-full
                    flex
                    justify-center
                    py-2
                    px-4
                    border border-transparent
                    rounded-md
                    shadow-sm
                    text-sm
                    font-medium
                    text-white
                    bg-emerald-600
                    hover:bg-emerald-700
                    focus:outline-none
                    focus:ring-2
                    focus:ring-offset-2
                    focus:ring-emerald-500
                    disabled:bg-slate-50
                    disabled:text-slate-500
                    disabled:border-slate-200
                    disabled:shadow-none
                "
                :disabled="loading || !isValidVote"
            >
                <template v-if="loading"
                    ><svg
                        class="animate-spin -ml-1 mr-3 h-5 w-5 text-slate-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        ></path></svg></template
                ><template v-else>Confirmar</template>
            </button>
        </div>
    </div>
</template>

<script>
import { polls } from "./settings";
import hash from "object-hash";

export default {
    name: "AppVote",

    props: ["member"],

    data() {
        return {
            polls,
            loading: false,
            vote: [],
        };
    },

    computed: {
        isValidVote() {
            let isValid = true;
            const vote = [...this.vote];

            polls.forEach((p) => {
                const pollOptions = [p.title, ...p.candidates.map((c) => c.id)];
                if (!pollOptions.some((o) => vote.includes(o))) {
                    isValid = false;
                }
            });

            return isValid;
        },
    },

    methods: {
        getMaxAllowedCandidates(poll) {
            let maxNumVotes = 0;

            if (!poll.votesPerMember) {
                maxNumVotes = poll.candidates.length;
            }

            return `${maxNumVotes} candidato${maxNumVotes > 1 ? "s" : ""}`;
        },

        prepareVotePayload() {
            const { name, dob } = this.member;
            let voteList = [...this.vote];
            const pollTitles = polls.map((p) => p.title);
            const blankVotes = voteList.filter((vote) =>
                pollTitles.includes(vote)
            );

            blankVotes.forEach((b) => {
                const pollIndex = polls.findIndex((p) => p.title === b);
                const pollIds = polls[pollIndex].candidates.map((c) => c.id);
                voteList = voteList.filter((v) => !pollIds.includes(v));
            });

            voteList = voteList.map((v) => (pollTitles.includes(v) ? 0 : v)); // remove blank vote markers
            voteList = Array.from(new Set(voteList)); // remove duplicated blanks

            return {
                hash: hash.MD5(`${name}${dob}`),
                voteList,
            };
        },

        async sendVote() {
            this.loading = true;

            const vote = this.prepareVotePayload();

            try {
                await axios.post("/api/vote", vote);
                this.$emit("confirmed", 2);
            } catch (e) {
              if (e.response.status === 400) {
                this.$emit("confirmed", 5)
              } else {
                this.$emit("confirmed", 3);

              }
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
