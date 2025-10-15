export default class AppError extends Error {
    public msg: string | string[];

    constructor(msg: string | string[] | null | undefined) {
        super();
        this.msg = msg || "Erro inesperado ao consultar API da aplicação.";
    }
}