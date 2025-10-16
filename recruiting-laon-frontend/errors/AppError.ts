export default class AppError extends Error {
    public status: number;
    public msg: string | string[];

    constructor(status: number, msg: string | string[] | null | undefined) {
        super();
        this.status = status;
        this.msg = msg || "Erro inesperado ao consultar API da aplicação.";
    }
}