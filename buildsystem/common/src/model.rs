use std::io::Write;

#[derive(Debug, serde::Serialize)]
pub struct BlogPost {
    pub title: String,
    pub description: String,
    pub is_draft: bool,
    pub body: String,
}

impl BlogPost {
    pub fn write_to_file(&self, path: &std::path::Path) -> std::io::Result<()> {
        let mut file = std::fs::File::create(path)?;
        file.write_all(serde_json::to_string(self).unwrap().as_bytes())?;
        Ok(())
    }
}
