package com.adaptionsoft.games.trivia;

import java.io.ByteArrayOutputStream;
import java.io.OutputStream;
import java.io.PrintStream;
import java.nio.ByteBuffer;
import java.nio.charset.Charset;
import java.nio.file.Files;
import java.nio.file.Paths;

import org.junit.Assert;
import org.junit.Test;

import com.adaptionsoft.games.trivia.runner.GameRunner;

public class GoldenMasterTest {

	private static final String GOLDEN_MASTER_PATH = "golden-master.out";
	private static final int RUNS = 100;

	@Test
	public void goldenMasterMatchesMultipleTriviaRunsOutput() throws Exception {
		if (Files.exists(Paths.get(GOLDEN_MASTER_PATH))) { 
			writeGoldenMaster();
		}

		String goldenMasterContent = readGoldenMaster(); 
		OutputStream outputStream = new ByteArrayOutputStream(); 
		runTrivia(new PrintStream(outputStream)); 

		Assert.assertEquals(goldenMasterContent, outputStream.toString());
	}

	private void writeGoldenMaster() throws Exception {
		PrintStream output = new PrintStream(GOLDEN_MASTER_PATH);
		runTrivia(output);
	}

	private String readGoldenMaster() throws Exception {
		byte[] bytes = Files.readAllBytes(Paths.get(GOLDEN_MASTER_PATH));
		return Charset.defaultCharset().decode(ByteBuffer.wrap(bytes)).toString();
	}

	private void runTrivia(PrintStream output) {
		System.setOut(output);
		for (int i = 1; i <= RUNS; i++) {
			GameRunner.main(new String[]{String.valueOf(i)});
		}
		output.flush();
		System.setOut(System.out);
	}
}
