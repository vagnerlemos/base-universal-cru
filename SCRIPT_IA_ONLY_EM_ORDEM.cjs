// IA_BUILDER_KAISER_IA_ONLY.cjs
// Gera um único arquivo IA-friendly com índice + blocos FILE_START/FILE_END
// Respeita rigorosamente a ORDEM das pastas e arquivos declarados no CONFIG

const fs = require("node:fs");
const path = require("node:path");

const CONFIG = {
    // 📜 Constituição / diretrizes
    PASTAS1: [
        "docs/00_ACTIVE",
    ],

    // 🧠 Código-fonte principal
    PASTAS: [
        "app",
        "config",
        "database",
        "resources",
        "routes",
        /* */
    ],

    // 📄 Arquivos específicos (ordem explícita)
    ARQUIVOS: [
        "config/app.php",
        /*"app/Models/User.php",
        ".env",
        */
    ],

    // 🚫 Exclusões globais
    IGNORAR: [
        "vendor",
        "node_modules",
        ".git",
        ".idea",
        "dist",
        "docs/01_PACKAGES",
        "docs/02_BUILDERS",
        "docs/03_SNAPSHOT",
        "docs/90_ARCHIVE",
        /*
        "docs/05_HISTORIA",
        */
    ],

    //MEGA_FILE: "Y-00-CONSTITUICAO.md",
    MEGA_FILE: "Y-v4-05-CODIGO-FONTE.md",

};

// NODE SCRIPT_IA_ONLY_EM_ORDEM.cjs




// ============================================================

const RAIZ = process.cwd();

/* ============================================================
   Utils
============================================================ */

function caminhoRel(abs) {
    return path.relative(RAIZ, abs).replaceAll("\\", "/");
}

function deveIgnorar(absPath) {
    const norm = absPath.replaceAll("\\", "/");
    return CONFIG.IGNORAR.some(p =>
        norm.includes(`/${p}/`) || norm.endsWith(`/${p}`)
    );
}

function normalizar(texto) {
    return texto.replaceAll("\r\n", "\n").trim();
}

/* ============================================================
   Coleta com ordem preservada
============================================================ */

/**
 * Coleta arquivos de uma pasta, mantendo:
 * - ordem natural do fs
 * - profundidade previsível
 * - sem sort global
 */
function coletarPasta(baseDir, lista) {
    const itens = fs.readdirSync(baseDir, { withFileTypes: true });

    for (const item of itens) {
        const full = path.join(baseDir, item.name);

        if (deveIgnorar(full)) continue;

        if (item.isDirectory()) {
            coletarPasta(full, lista);
        } else {
            lista.push(full);
        }
    }
}

/**
 * Resolve arquivo individual respeitando ordem do CONFIG
 */
function resolverArquivo(relPath) {
    const abs = path.resolve(RAIZ, relPath);

    if (!fs.existsSync(abs)) {
        console.log("⚠️ Arquivo não encontrado:", relPath);
        return null;
    }

    if (deveIgnorar(abs)) {
        console.log("⚠️ Arquivo ignorado:", relPath);
        return null;
    }

    return abs;
}

/* ============================================================
   MAIN
============================================================ */

function main() {
    console.log("🧠 IA_BUILDER_KAISER (ORDEM CANÔNICA) iniciado...");

    const arquivos = [];
    const vistos = new Set();

    function pushArquivo(abs) {
        if (!vistos.has(abs)) {
            vistos.add(abs);
            arquivos.push(abs);
        }
    }

    // 🔹 1. Pastas (ordem exata do CONFIG)
    for (const pasta of CONFIG.PASTAS) {
        const base = path.resolve(RAIZ, pasta);
        if (!fs.existsSync(base)) continue;

        const coletados = [];
        coletarPasta(base, coletados);

        for (const abs of coletados) {
            pushArquivo(abs);
        }
    }

    // 🔹 2. Arquivos individuais (ordem explícita)
    for (const arq of CONFIG.ARQUIVOS) {
        const abs = resolverArquivo(arq);
        if (abs) pushArquivo(abs);
    }

    if (arquivos.length === 0) {
        console.log("⚠️ Nenhum arquivo encontrado.");
        return;
    }

    const linhas = [];

    // 📑 Índice IA-friendly
    linhas.push("=== AI_FILE_INDEX ===");
    for (const abs of arquivos) {
        linhas.push(`FILE: ${caminhoRel(abs)}`);
    }
    linhas.push("=== END_AI_FILE_INDEX ===\n");

    // 📄 Conteúdo dos arquivos
    for (const abs of arquivos) {
        const rel = caminhoRel(abs);
        const conteudo = normalizar(fs.readFileSync(abs, "utf8"));

        linhas.push(
            `<<<FILE_START: ${rel}>>>\n` +
            conteudo +
            `\n<<<FILE_END: ${rel}>>>\n`
        );
    }

    fs.writeFileSync(
        path.join(RAIZ, CONFIG.MEGA_FILE),
        linhas.join("\n"),
        "utf8"
    );

    console.log("✅ Gerado:", CONFIG.MEGA_FILE);
    console.log("🎉 Ordem respeitada. Script limpo e canônico.");
}

main();
