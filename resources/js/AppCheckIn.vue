<template>
    <div class="">
        <div class="">
            <Combobox as="div" v-model="member">
                <ComboboxLabel class="block font-medium text-gray-700"
                    >Selecione seu nome na lista abaixo:</ComboboxLabel
                >
                <div class="relative mt-1">
                    <ComboboxInput
                        class="
                            w-full
                            rounded-md
                            border border-gray-300
                            bg-white
                            py-2
                            pl-3
                            pr-10
                            shadow-sm
                            focus:border-emerald-500
                            focus:outline-none
                            focus:ring-1
                            focus:ring-emerald-500
                            sm:text-sm
                        "
                        placeholder="Digite para pesquisar"
                        @change="query = $event.target.value"
                        :display-value="(person) => person?.name"
                    />
                    <ComboboxButton
                        class="
                            absolute
                            inset-y-0
                            right-0
                            flex
                            items-center
                            rounded-r-md
                            px-2
                            focus:outline-none
                        "
                    >
                        <SelectorIcon
                            class="h-5 w-5 text-gray-400"
                            aria-hidden="true"
                        />
                    </ComboboxButton>

                    <ComboboxOptions
                        v-if="filteredPeople.length > 0"
                        class="
                            absolute
                            z-10
                            mt-1
                            max-h-60
                            w-full
                            overflow-auto
                            rounded-md
                            bg-white
                            py-1
                            text-base
                            shadow-lg
                            ring-1 ring-black ring-opacity-5
                            focus:outline-none
                            sm:text-sm
                        "
                    >
                        <ComboboxOption
                            v-for="person in filteredPeople"
                            :key="person.id"
                            :value="person"
                            as="template"
                            v-slot="{ active, selected }"
                        >
                            <li
                                :class="[
                                    'relative cursor-default select-none py-2 pl-8 pr-4',
                                    active
                                        ? 'bg-emerald-600 text-white'
                                        : 'text-gray-900',
                                ]"
                            >
                                <span
                                    :class="[
                                        'block truncate',
                                        selected && 'font-semibold',
                                    ]"
                                >
                                    {{ person.name }}
                                </span>

                                <span
                                    v-if="selected"
                                    :class="[
                                        'absolute inset-y-0 left-0 flex items-center pl-1.5',
                                        active
                                            ? 'text-white'
                                            : 'text-emerald-600',
                                    ]"
                                >
                                    <CheckIcon
                                        class="h-5 w-5"
                                        aria-hidden="true"
                                    />
                                </span>
                            </li>
                        </ComboboxOption>
                    </ComboboxOptions>
                </div>
            </Combobox>
        </div>
        <p class="font-medium text-gray-700 mt-5">
            Preencha sua data de nascimento:
        </p>
        <div class="mt-0 flex gap-1">
            <div class="flex-grow-1">
                <label for="day" class="block text-sm font-medium text-gray-700"
                    >Dia</label
                >
                <div class="mt-1">
                    <input
                        type="number"
                        v-model="dob.day"
                        min="1"
                        max="31"
                        name="day"
                        id="day"
                        class="
                            shadow-sm
                            focus:ring-emerald-500 focus:border-emerald-500
                            block
                            w-full
                            sm:text-sm
                            border-gray-300
                            rounded-md
                        "
                        placeholder="DD"
                    />
                </div>
            </div>
            <div class="flex-grow-1">
                <div>
                    <label
                        for="month"
                        class="block text-sm font-medium text-gray-700"
                        >Mês</label
                    >
                    <select
                        v-model="dob.month"
                        id="month"
                        name="location"
                        class="
                            mt-1
                            block
                            w-full
                            pl-3
                            pr-10
                            py-2
                            text-base
                            border-gray-300
                            focus:outline-none
                            focus:ring-emerald-500
                            focus:border-emerald-500
                            sm:text-sm
                            rounded-md
                        "
                    >
                        <option hidden selected value="null">Mês</option>
                        <option value="01">Janeiro</option>
                        <option value="02">Fevereiro</option>
                        <option value="03">Março</option>
                        <option value="04">Abril</option>
                        <option value="05">Maio</option>
                        <option value="06">Junho</option>
                        <option value="07">Julho</option>
                        <option value="08">Agosto</option>
                        <option value="09">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>
                </div>
            </div>
            <div class="year-container">
                <label
                    for="year"
                    class="block text-sm font-medium text-gray-700"
                    >Ano (AAAA)</label
                >
                <div class="mt-1">
                    <input
                        v-model="dob.year"
                        min="1900"
                        max="2100"
                        type="number"
                        name="year"
                        id="year"
                        class="
                            shadow-sm
                            focus:ring-emerald-500 focus:border-emerald-500
                            block
                            w-full
                            sm:text-sm
                            border-gray-300
                            rounded-md
                        "
                        placeholder="AAAA"
                    />
                </div>
            </div>
        </div>
        <AppConfirmation :status="4" v-if="isInvalid" class="my-3" />
        <div class="mt-10">
            <button
                @click="validateMember"
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
                "
            >
                Avançar &gt;
            </button>
        </div>
    </div>
</template>

<script>
import { members } from "@/members";
import { CheckIcon, SelectorIcon } from "@heroicons/vue/solid";
import {
    Combobox,
    ComboboxButton,
    ComboboxInput,
    ComboboxLabel,
    ComboboxOption,
    ComboboxOptions,
} from "@headlessui/vue";
import AppConfirmation from "./AppConfirmation.vue";

export default {
    name: "AppCheckIn",
    components: {
        AppConfirmation,
        CheckIcon,
        SelectorIcon,
        Combobox,
        ComboboxButton,
        ComboboxInput,
        ComboboxLabel,
        ComboboxOption,
        ComboboxOptions,
    },
    data() {
        return {
            members,
            member: "Selecione",
            query: "",
            dob: {
                day: null,
                month: null,
                year: null,
            },
            isInvalid: false,
        };
    },
    computed: {
        filteredPeople() {
            return this.query === ""
                ? members
                : members.filter((person) => {
                      return person.name
                          .toLowerCase()
                          .startsWith(this.query.toLowerCase());
                  });
        },
    },
    methods: {
        getDob() {
            const { year, month, day } = this.dob;
            const formattedDob = `${year}-${("0" + month).slice(-2)}-${(
                "0" + day
            ).slice(-2)}`;
            return formattedDob;
        },

        validateMember() {
            if (this.getDob() === this.member?.dob) {
                this.isInvalid = false;
                this.$emit("validated", { ...this.member });
            } else {
                this.isInvalid = true;
            }
        },
    },
};
</script>

<style scoped>
.year-container {
    flex-grow: 2;
}
</style>
