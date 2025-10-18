"use client";
import React from "react";
import CustomModal from "../CustomModal";

interface InfoModal {
    title: string;
    info: string;
}
export default function InfoModal({ title, info }: InfoModal) {
    return <CustomModal>
        <h1 className="text-center text-4xl font-semibold mb-4">{title}</h1>
        <p className="text-center mb-4 text-md">{info}</p>
    </CustomModal>
}