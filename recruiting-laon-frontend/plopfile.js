export default function (plop) {
    plop.setGenerator("component", {
        description: "Create a new component",
        prompts: [
            {
                type: "input",
                name: "name",
                message: "Component name:"
            }
        ],
        actions: [
            {
                type: "add",
                path: "components/{{pascalCase name}}/index.tsx",
                templateFile: "plop-templates/component.tsx.hbs"
            }
        ]
    });
}