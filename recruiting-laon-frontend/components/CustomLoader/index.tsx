"use client";
import React from "react";
import { Bars } from "react-loader-spinner";

interface CustomLoaderProps {
    width?: number;
    height?: number;
}
export default function CustomLoader({ width, height }: Readonly<CustomLoaderProps>) {
    return <Bars
        width={width || 80}
        height={height || 80}
        color="#48465B"
        ariaLabel="bars-loading"
        visible={true}
    />;
}