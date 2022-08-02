<template>
    <div class="text-xl">
        <div class="" v-if="status === 2">
            <div class="rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <CheckCircleIcon
                            class="h-5 w-5 text-green-400"
                            aria-hidden="true"
                        />
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">
                            Confirmado
                        </h3>
                        <div class="mt-2 text-sm text-green-700">
                            <p>Seu voto foi salvo com sucesso.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="" v-if="status === 3">
            <div class="rounded-md bg-red-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <XCircleIcon
                            class="h-5 w-5 text-red-400"
                            aria-hidden="true"
                        />
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Erro</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>Um erro ocorreu ao salvar seu voto.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="" v-if="status === 4">
            <div class="rounded-md bg-red-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <XCircleIcon
                            class="h-5 w-5 text-red-400"
                            aria-hidden="true"
                        />
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            Dados incorretos
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>
                                A data de nascimento inserida não confere com a
                                registrada no rol de membros da igreja. Por
                                favor confira os dados e tente novamente.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { CheckCircleIcon, XCircleIcon } from "@heroicons/vue/solid";

export default {
    name: "AppConfirmation",
    components: { CheckCircleIcon, XCircleIcon },
    props: ["status"],
};
</script>

<style scoped></style>
